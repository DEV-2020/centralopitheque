<template>
  <div class="sign-up">
    <h1>{{ $t('signUp') }}</h1>
    <form @submit.prevent="register">
      <label for="username">{{ $t('username') }}</label>
      <input
        :class="{error: error === 'username'}"
        v-model="username"
        id="username"
        type="text">
      <small class="error" v-if="error === 'username'">{{ $t('errors.username') }}</small>
      <label for="email">{{ $t('email') }}</label>
      <input v-model="email" id="email" type="email">
      <label for="password">{{ $t('password') }}</label>
      <input
        :class="{error: !passwordsMatch}"
        v-model="password"
        id="password"
        type="password">
      <small v-if="!passwordsMatch">{{ $t('passwordDontMatch') }}</small>
      <label for="password-confirm">{{ $t('passwordConfirm') }}</label>
      <input
        :class="{error: !passwordsMatch}"
        v-model="passwordConfirm"
        id="password-confirm"
        type="password">
      <button :disabled="!password.length || !passwordsMatch" type="submit">
        <span v-if="!sendingRequest">{{ $t('signUp') }}</span>
        <Spinner v-else />
      </button>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Action } from 'vuex-class';
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';
import { readJwt, updateAccessToken, updateRefreshToken } from '@/utils/auth';
import routes from '@/constants/routes';
import { LoginJson } from '@/types/jwt';

@Component({
  components: {
    Spinner,
  },
})
export default class SignUp extends Vue {
  private username: string = '';
  private email: string = '';
  private password: string = '';
  private passwordConfirm: string = '';
  private error: string = '';
  private sendingRequest: boolean = false;

  @Action('setUser', { namespace: 'auth' }) setUser!: (data: LoginJson) => void;

  get passwordsMatch(): boolean {
    return this.password === this.passwordConfirm;
  }

  async register() {
    const { username, email, password } = this;
    this.error = '';
    this.sendingRequest = true;
    try {
      const response = await axios.post<LoginJson>(routes.REGISTER, {
        username,
        email,
        password,
      })
        .then(({ data }) => data);
      this.save(response);
      this.$router.push({ name: 'home' });
    } catch (e) {
      this.error = e.response.data.error;
    }
    this.sendingRequest = false;
  }

  save(data: LoginJson) {
    updateAccessToken(data.token);
    updateRefreshToken(data.refresh_token);
    this.setUser(data);
  }
}
</script>

<style lang="scss" scoped>
.sign-up {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 50px auto;
  padding: 20px 30px;
  box-sizing: border-box;
  flex-grow: inherit;
  background-color: rgba($primary, .4);

  h1 {
    text-align: left;
    margin-bottom: 10px;
  }

  form {
    min-width: 300px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    font-size: 1.2em;
    font-weight: 500;

    input:not([type=submit]) {
      width: 100%;
      box-sizing: border-box;
      margin: 5px 0 10px;
      padding: 10px;
      font-size: .9em;
      border-radius: 5px;
      border: solid 1px rgba(#444, .1);

      &.error {
        border: solid 1px rgba($error, .8);
        box-shadow: 0 0 3px 3px rgba($error, .5);

        +small {
          color: $error;
          margin: -5px 0 5px;
        }
      }
    }

    button[type=submit] {
      margin: 10px auto 0;
      padding: 5px 30px;
      border: none;
      background-color: #fff;
      color: $primary;
      cursor: pointer;
      border-radius: 5px;
      font-size: 1em;
      font-weight: 500;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: height .2s;

      &:disabled {
        color: #ccc;
        cursor: inherit;
      }

      .spinner {
        height: 30px;
      }
    }
  }
}
</style>
