import axios from 'axios';
import config from '../config';

/**
 * Makes an API call. Returns a promise with  { status, error, payload }
 * status is the HTTP status code
 * error is a best effort at a map containing a message or sometimes validation messages
 * payload is the json payload if the call is successful
 *
 * By default some actions are taken here upon some codes (check generateHelper).
 * If you don't want these actions to take place, pass the codes to ignore in ignoreCodes.
 *
 * @param {*} method GET, PUT,... GET is the default
 * @param {*} url Relative endpoint of the API. Don't forget a leading slash (e.g. /users)
 * @param {*} params Optional parameters
 * @param {*} ignoreCodes HTTP status codes to ignore (see generateHelper)
 * @return A promise that never fails and returns { status, error, payload }
 */

export function call(method, url, params, ignoreCodes) {
    const x = config.rootURI;
    const fullUrl = x + url;
    const axiosParams = {
        method: method || 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*'
        }
    };

    if (params) {
        if (axiosParams.method === 'GET') {
            axiosParams.params = params;
        } else {
            axiosParams.data = params;
        }
    }

    return axios(fullUrl, axiosParams)
        .then(generateHelper(ignoreCodes))
        .catch(error => {
            console.log(error)
            let status = error.response.status
            let errorData = error.response.data
            const value = { payload: null, status: status };
            switch (status) {
                case 422:
                    //field validation failed
                    Object.assign(value, { error: { message: 'Field validation failed.', validationError: errorData.data } })
                    break
                case 400:
                    // we do not have valid access
                    Object.assign(value, { error: { message: 'Can not process your request.' } });
                    break;
                case 401:
                    // We don't have a valid session
                    Object.assign(value, { error: { message: errorData.message } });
                    break;
                case 404:
                    // No records found
                    Object.assign(value, { error: { message: errorData.message } });
                    break;
                default:
                    Object.assign(value, { error: { message: 'Check your internet connection.' } });
                    break;
            }

            return value;
        });
}

/**
 * Generate a function to handle responses
 * Pass HTTP status codes (array) that you want to process in the caller
 * @param {*} ignoreCodes
 */
function generateHelper(ignoreCodes) {
    return (response) => {
        console.log(response)
        const status = response.status;

        if ((ignoreCodes && ignoreCodes.indexOf(status) > -1) || (status >= 200 && status < 300)) {

            return {
                payload: response.data.data,
                status: response.data.status_code ? response.data.status_code : status,
                paginator: response.data.paginator ? response.data.paginator : null
            };
        }
    };
}
