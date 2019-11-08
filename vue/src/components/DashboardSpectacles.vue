<template>
  <div class="dashboard-spectacles">
    <div class="spectacles-list"></div>
    <router-link :to="{name: 'spectacles-manage'}">{{ $t('manageSpectacles') }}</router-link>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class DashboardSpectacles extends Vue {}
</script>

<style lang="scss" scoped>
.dashboard-spectacles {
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  a {
    color: $blue;
  }
}
</style>
