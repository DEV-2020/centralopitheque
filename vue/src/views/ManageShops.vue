<template>
  <div class="manage-shops">
    <h1>{{ $t('shopsManagement') }}</h1>
    <!-- <ul class="actions">
      <li class="green">
        <router-link :to="{name: 'new-spectacle'}"><span>+</span>Créer</router-link>
      </li>
    </ul> -->
    <div class="shops-list">
      <table>
        <thead>
          <tr>
            <td class="left">{{ $t('shop') }}</td>
            <td class="left">{{ $t('email') }}</td>
            <td class="left">{{ $t('url') }}</td>
          </tr>
        </thead>
        <tbody v-if="!shops.length">
          <tr>
            <td colspan="5">
              <Spinner v-if="!loaded" :stroke="'#2ecc71'" />
              <p class="empty-list" v-else>{{ $t('noShops') }}</p>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr
            @click="goToDetail(shop)"
            v-for="shop in shops"
            :key="shop.id">
            <td class="left">{{ shop.name }}</td>
            <td class="left">{{ shop.owner && shop.owner.email }}</td>
            <td>
              <a :href="shop.url" class="left" v-if="shop.url">{{ shop.url }}</a>
              <span v-else>ø</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Action, Getter } from 'vuex-class';
import routes from '@/constants/routes';
import { Shop } from '@/types/shops';

@Component
export default class ManageShops extends Vue {
  private loaded: boolean = false;
  @Getter('shops', { namespace: 'shops' }) shops!: Shop[];
  @Action('setShops', { namespace: 'shops' }) setShops!: (shops: Shop[]) => void;

  created() {
    this.$api.get<Shop[]>(routes.SHOPS_LIST)
      .then(({ data }) => {
        this.loaded = true;
        this.setShops(data);
      })
      .catch(() => {
        this.$notify({
          text: this.$tc('errors.errorOccurredWhile', undefined, {
            reason: this.$tc('errors.fetchingShops'),
          }),
          group: 'notifications',
          type: 'error',
        });
      });
  }

  goToDetail(shop: Shop) {
    this.$router.push({
      name: 'shop-detail',
      params: {
        id: shop.id.toString(),
      },
    });
  }
}
</script>

<style lang="scss" scoped>
.manage-shops {
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

  .shops-list {
    margin: 20px 0;
    table {
      thead {
        background-color: $gray;
      }

      tbody tr {
        cursor: pointer;
      }

      td {
        padding: 5px 10px;

        &.left {
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
