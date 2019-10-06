const baseUrl = process.env.VUE_APP_API_URL;

export default {
  TOKEN_REFRESH: `${baseUrl}/token/refresh`,
  LOGIN_CHECK: `${baseUrl}/login_check`,
  REGISTER: `${baseUrl}/public/register`,
};
