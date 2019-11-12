module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/essential',
    '@vue/airbnb',
    '@vue/typescript',
  ],
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'import/no-unresolved': 'off',
    'lines-between-class-members': 'off',
    'consistent-return': 'off',
    'class-methods-use-this': 'off',
    'import/extensions': [2, {
      vue: 'always',
      js: 'never',
      ts: 'never',
      scss: 'always',
    }]
  },
  parserOptions: {
    parser: '@typescript-eslint/parser',
  },
};
