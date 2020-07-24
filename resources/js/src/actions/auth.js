export const actionTypes = {
  LOGIN_USER: "LOGIN_USER",
  LOGIN_SUCCESS: "LOGIN_SUCCESS",
  LOGIN_FAILED: "LOGIN_FAILED",

  LOGOUT_USER: "LOGOUT_USER",
  LOGOUT_SUCCESS: "LOGOUT_SUCCESS",
  LOGOUT_FAILED: "LOGOUT_FAILED"
};

export const actions = {
  login: (credentials) => ({ type: actionTypes.LOGIN_USER, credentials }),
  loginSuccess: (user, statusCode) => ({ type: actionTypes.LOGIN_SUCCESS, user, statusCode }),
  loginFailure: (error, statusCode) => ({ type: actionTypes.LOGIN_FAILED, error, statusCode }),

  logout: () => ({ type: actionTypes.LOGOUT_USER }),
  logoutSuccess: () => ({ type: actionTypes.LOGOUT_SUCCESS }),
  logoutFailure: (error, statusCode) => ({ type: actionTypes.LOGOUT_FAILED, error, statusCode })
};