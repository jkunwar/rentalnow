import { actionTypes } from '../actions/auth';

const INITIAL_STATE = {
  data: {},
  error: null,
  statusCode: null,
  isAuthenticated: false,
  loading: false
};

export const login = (state = INITIAL_STATE, action) => {
  switch (action.type) {
    case actionTypes.LOGIN_USER:
      return {
        ...state, error: null, loading: true
      }
    case actionTypes.LOGIN_SUCCESS:
      return {
        ...state,
        data: action.user,
        error: null,
        loading: false,
        statusCode: action.statusCode,
        isAuthenticated: true
      };
    case actionTypes.LOGIN_FAILED:
      return {
        ...state,
        error: action.error,
        statusCode: action.statusCode,
        isAuthenticated: false,
        loading: false
      };

    case actionTypes.LOGOUT_SUCCESS:
      return {
        ...state,
        data: {},
        error: null,
        statusCode: null,
        isAuthenticated: false,
        loading: false
      };
    default:
      return state;
  }
}