<template>
  <div class="dashboard-shops">
    <div class="shops-list"></div>
    <router-link :to="{name: 'shops-manage'}">{{ $t('manageShops') }}</router-link>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class DashboardShops extends Vue {}
</script>

<style lang="scss" scoped>
.dashboard-shops {
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  a {
    color: $blue;
  }
}
</style>
