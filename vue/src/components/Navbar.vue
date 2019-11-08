<template>
  <nav class="navbar">
    <h1><router-link to="/">Centralopithèque</router-link></h1>
    <ul v-if="!loggedIn">
      <li><router-link to="sign-up">{{ $t('signUp') }}</router-link></li>
      <li><router-link to="sign-in">{{ $t('signIn') }}</router-link></li>
    </ul>
    <ul v-else>
      <li><router-link to="dashboard"><b>{{ user.username }}</b></router-link></li>
      <li><a @click="logoutClick">{{ $t('logout') }}</a></li>
    </ul>
  </nav>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Getter, Action } from 'vuex-class';
import { User } from '@/types/jwt';

@Component
export default class Navbar extends Vue {
  @Getter('loggedIn', { namespace: 'auth' }) loggedIn!: boolean;
  @Getter('user', { namespace: 'auth' }) user!: User;
  @Action('logout', { namespace: 'auth' }) logout!: () => void;

  logoutClick() {
    this.logout();
    this.$router.replace('/').catch(() => {});
    this.$notify({
      group: 'notifications',
      type: 'success',
      text: this.$tc('logoutSuccess'),
    });
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  width: 100%;
  box-sizing: border-box;
  padding: 10px 30px;
  background-color: $primary;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #fff;

  h1 a {
    text-decoration: inherit;
    color: inherit;
  }

  ul {
    display: flex;
    align-items: center;

    > li {
      margin-left: 15px;

      a {
        text-decoration: none;
        color: $white;
        position: relative;
        cursor: pointer;

        &:after {
          content: '';
          position: absolute;
          width: 0;
          bottom: -5px;
          left: 50%;
          transform: translateX(-50%);
          transition: width .2s;
          height: 3px;
          background-color: $white;
        }

        &:hover {
          opacity: .8;
          &:after {
            width: 50%;
          }
        }
      }
    }
  }
}
</style>
