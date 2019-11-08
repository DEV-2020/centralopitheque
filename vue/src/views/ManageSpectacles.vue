<template>
  <div class="manage-spectacles">
    <h1>{{ $t('spectaclesManagement') }}</h1>
    <ul class="actions">
      <li class="green">
        <router-link :to="{name: 'new-spectacle'}"><span>+</span>Créer</router-link>
      </li>
    </ul>
    <div v-if="spectacleList.length" class="spectacles-list"></div>
    <p class="empty-list">No spectacles available</p>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class ManageSpectacles extends Vue {
  private spectacleList = [];
}
</script>

<style lang="scss" scoped>
.manage-spectacles {
  margin: 20px;

  h1 {
    text-align: left;
    margin: 20px 0;
  }

  ul {
    display: flex;

    > li {
      display: flex;
      align-items: center;
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: 600;

      a {
        text-decoration: none;
        color: $white;
      }

      span {
        margin-right: 5px;
      }

      &.green {
        background-color: $primary;
      }
    }
  }

  p.empty-list {
    text-align: left;
    opacity: .7;
    margin: 30px 0;
  }
}
</style>
