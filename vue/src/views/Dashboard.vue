<template>
  <div class="dashboard">
    <h1>Dashboard</h1>
    <div class="row copy-token">
      <h2>Token</h2>
      <p :title="refreshToken">
        {{ $t('copyToken') }}
        <CopyClipboard
          :text="$t('tokenCopied')"
          :copy="refreshToken"/>
      </p>
    </div>
    <div v-if="isAdmin" class="row dashboard-spectacles">
      <h2>Spectacles</h2>
      <DashboardSpectacles />
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Getter } from 'vuex-class';
import CopyClipboard from '@/components/CopyClipboard.vue';
import DashboardSpectacles from '@/components/DashboardSpectacles.vue';
import { getRefreshToken } from '@/utils/auth';

@Component({
  components: {
    CopyClipboard,
    DashboardSpectacles,
  },
})
export default class Dashboard extends Vue {
  @Getter('isAdmin', { namespace: 'auth' }) isAdmin!: boolean;

  get refreshToken(): string {
    return getRefreshToken()!;
  }
}
</script>

<style lang="scss" scoped>
.dashboard {
  margin: 20px 50px;
  align-items: flex-start;

  h1 {
    margin-bottom: 30px;
  }

  h2 {
    margin: 10px 0;
  }

  h1, h2 {
    text-align: left;
  }

  .row {
    &.copy-token p {
      display: flex;
    }
  }
}
</style>
