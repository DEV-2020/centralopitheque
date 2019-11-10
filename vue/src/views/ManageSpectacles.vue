<template>
  <div class="manage-spectacles">
    <h1>{{ $t('spectaclesManagement') }}</h1>
    <ul class="actions">
      <li class="green">
        <router-link :to="{name: 'new-spectacle'}"><span>+</span>Créer</router-link>
      </li>
    </ul>
    <div v-if="spectacleList.length" class="spectacles-list">
      <table>
        <thead>
          <!-- <td>ID</td> -->
          <td>Name</td>
          <td>Places</td>
          <td>Price</td>
          <td>Date</td>
          <td>Heure</td>
        </thead>
        <tbody>
          <tr v-for="item in spectacleList" :key="item.id">
            <!-- <td>{{ item.id }}</td> -->
            <td>{{ item.name }}</td>
            <td>{{ item.places }}</td>
            <td>{{ item.price }}€</td>
            <td>{{ toReadableDate(item.date) }}</td>
            <td>{{ item.hours | padded }}:{{ item.minutes | padded }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else class="empty-list">No spectacles available</p>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import routes from '@/constants/routes';
import { toReadableDate } from '@/utils/time-converter';
import { Spectacle } from '@/types/spectacles';

@Component({
  filters: {
    padded(str: number) {
      return str.toString().padStart(2, '0');
    },
  },
})
export default class ManageSpectacles extends Vue {
  private spectacleList: Spectacle[] = [];

  toReadableDate(date: Date) {
    return toReadableDate(new Date(date));
  }

  created() {
    this.$api.get<Spectacle[]>(routes.SPECTACLES_LIST)
      .then(({ data }) => {
        this.spectacleList = data;
      })
      .catch(console.error);
  }
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

  .spectacles-list {
    margin: 20px 0;
    table {
      td {
        padding: 5px 10px;
      }

      tr:nth-child(even) {
        background-color: $gray;
      }
    }
  }
}
</style>
