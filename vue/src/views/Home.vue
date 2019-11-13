<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <h1>La Centralopithèque</h1>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class Home extends Vue {}
</script>

<style lang="scss" scoped>
.home {
  margin: 50px 0;
  h1 {
    font-size: 3em;
  }
}
</style>
