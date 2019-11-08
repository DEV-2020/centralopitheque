<template>
  <div id="app">
    <Navbar />
    <transition name="fade" mode="out-in">
      <router-view class="router-view"/>
    </transition>
    <notifications
      classes="vue-notification"
      group="notifications"
      position="bottom left"/>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Action } from 'vuex-class';
import '@/assets/scss/reset.scss';
import '@/assets/scss/notifications.scss';
import Navbar from '@/components/Navbar.vue';
import { isTokenValid } from './utils/auth';

@Component({
  components: {
    Navbar,
  },
})
export default class App extends Vue {
  @Action('logout', { namespace: 'auth' }) logout!: () => void;

  created() {
    if (!isTokenValid()) {
      this.logout();
      this.$router.replace('sign-in').catch(() => {});
      this.$notify({
        group: 'notifications',
        type: 'error',
        text: this.$tc('expiredSession'),
      });
    }
  }
}
</script>

<style lang="scss">
.vue-notification {
  padding: 10px;
  margin: 50px;

  font-size: 24px;

  color: #ffffff;
  background: #44A4FC;
  border-left: 5px solid #187FE7;

  &.warn {
    background: #ffb648;
    border-left-color: #f48a06;
  }

  &.error {
    background: #E54D42;
    border-left-color: #B82E24;
  }

  &.success {
    background: #68CD86;
    border-left-color: #42A85F;
  }
}

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  height: 100vh;
  display: flex;
  flex-direction: column;
}

.router-view {
  flex-grow: 1;
}

.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.2s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0
}
</style>
