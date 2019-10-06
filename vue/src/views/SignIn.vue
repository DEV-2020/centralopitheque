<template>
  <div class="sign-in">
    <h1>{{ $t('signUp') }}</h1>
    <form @submit.prevent="login">
      <label for="username">{{ $t('username') }}</label>
      <input v-model="username" id="username" type="text">
      <label for="password">{{ $t('password') }}</label>
      <input v-model="password" id="password" type="password">
      <p v-if="error">{{ $t('invalidCredentials') }}</p>
      <button :disabled="!password.length" type="submit">
        <span v-if="!sendingRequest">{{ $t('signIn') }}</span>
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
import { updateAccessToken, updateRefreshToken } from '@/utils/auth';
import { LoginJson } from '@/types/jwt';

@Component({
  components: {
    Spinner,
  },
})
export default class SignIn extends Vue {
  private username: string = '';
  private password: string = '';
  private sendingRequest: boolean = false;
  private error: boolean = false;

  @Action('setUser', { namespace: 'auth' }) setUser!: (data: LoginJson) => void;

  async login() {
    const url = `${process.env.VUE_APP_API_URL}/login_check`;
    const { username, password } = this;
    this.sendingRequest = true;
    this.error = false;
    try {
      const response = await axios.post(url, {
        username,
        password,
      })
        .then(({ data }) => data);
      this.save(response);
      this.$router.push({ name: 'home' });
    } catch (e) {
      this.error = true;
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
.sign-in {
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

    p {
      align-self: center;
      color: $error;
    }

    input:not([type=submit]) {
      width: 100%;
      box-sizing: border-box;
      margin: 5px 0 10px;
      padding: 10px;
      font-size: .9em;
      border-radius: 5px;
      border: solid 1px rgba(#444, .1);
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
