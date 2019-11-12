<template>
  <div class="manage-spectacles">
    <h1>{{ $t('spectaclesManagement') }}</h1>
    <ul class="actions">
      <li class="green">
        <router-link :to="{name: 'new-spectacle'}"><span>+</span>Créer</router-link>
      </li>
    </ul>
    <div class="spectacles-list">
      <table>
        <thead>
          <td class="name">{{ $t('name') }}</td>
          <td>{{ $t('places') }}</td>
          <td>{{ $t('price') }}</td>
          <td>{{ $t('date') }}</td>
          <td>{{ $t('time') }}</td>
        </thead>
        <tbody v-if="!spectacles.length">
          <tr>
            <td colspan="5">
              <Spinner v-if="!loaded" :stroke="'#2ecc71'" />
              <p class="empty-list" v-else>{{ $t('noSpectaclesAvailable') }}</p>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr v-for="item in spectacles" :key="item.id">
            <td class="name">{{ item.name }}</td>
            <td>{{ item.places }}</td>
            <td>{{ item.price }}€</td>
            <td>{{ item.date | toReadableDate }}</td>
            <td>{{ item.hours | padded }}:{{ item.minutes | padded }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Getter, Action } from 'vuex-class';
import routes from '@/constants/routes';
import { toReadableDate } from '@/utils/time-converter';
import { Spectacle } from '@/types/spectacles';

@Component({
  filters: {
    padded(str: number) {
      return str.toString().padStart(2, '0');
    },
    toReadableDate,
  },
})
export default class ManageSpectacles extends Vue {
  private loaded: boolean = false;
  @Getter('spectacles', { namespace: 'spectacles' }) private spectacles!: Spectacle[];

  @Action('setSpectacles', { namespace: 'spectacles' })
  setSpectacles!: (spectacles: Spectacle[]) => void;

  created() {
    this.$api.get<Spectacle[]>(routes.SPECTACLES_LIST)
      .then(({ data }) => {
        this.loaded = true;
        this.setSpectacles(data);
      })
      .catch(console.error);
  }
}
</script>

<style lang="scss" scoped>
.manage-spectacles {
  margin: 20px;

  .spinner {
    height: 40px;
    margin: 10px;
  }

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

  .spectacles-list {
    margin: 20px 0;
    table {
      thead {
        background-color: $gray;
      }

      td {
        padding: 5px 10px;

        &.name {
          text-align: left;
        }

        p.empty-list {
          text-align: center;
          opacity: .7;
        }
      }

      tr:nth-child(even) {
        background-color: $gray;
      }
    }
  }
}
</style>
