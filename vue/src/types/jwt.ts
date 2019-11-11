/* eslint-disable import/prefer-default-export, camelcase */

export interface JWT {
  iat: number;
  exp: number;
  roles: string[];
  username: string;
}

export interface LoginJson {
  token: string;
  refresh_token: string;
}

export interface ApiUser {
  id: number;
  username: string;
  roles: string[];
  email: string;
}

export interface User {
  username: string;
  roles: string[];
}
