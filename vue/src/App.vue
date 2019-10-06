<template>
  <div id="app">
    <Navbar />
    <transition name="fade" mode="out-in">
      <router-view class="router-view"/>
    </transition>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import '@/assets/scss/reset.scss';
import Navbar from '@/components/Navbar.vue';

export default Vue.extend({
  name: 'App',
  components: {
    Navbar,
  },
});
</script>

<style lang="scss">
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
