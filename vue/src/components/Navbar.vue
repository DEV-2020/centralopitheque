<template>
  <nav class="navbar">
    <h1>Centralopithèque</h1>
    <ul>
      <li><router-link to="sign-up">{{ $t('signUp') }}</router-link></li>
      <li><router-link to="sign-in">{{ $t('signIn') }}</router-link></li>
    </ul>
  </nav>
</template>

<script lang="ts">
import Vue from 'vue';

export default Vue.extend({
  name: 'Navbar',
});
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

  ul {
    display: flex;
    align-items: center;

    > li {
      margin-left: 10px;

      a {
        text-decoration: none;
        color: $white;
        position: relative;

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
