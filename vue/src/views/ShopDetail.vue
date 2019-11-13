<template>
  <div class="shop-detail">
    <h1>{{ $t('shop') }}</h1>
    <Spinner v-if="!loaded" stroke="#2ecc71" />
    <div class="shop-info" v-if="shop">
      <h2>{{ shop.name }}</h2>
      <a v-if="shop.owner" :href="`mailto:${shop.owner.email}`">{{ shop.owner.email }}</a>
      <div class="spectacles">
        <h2>{{ $t('spectacles') }}
          <span>({{ shop.spectacles.length }}/3)</span>
          <span>
            <ul class="actions">
              <li class="green">
                <router-link
                  :to="{name: 'shop-spectacles'}">
                  <span>+</span>{{ $t('add') }}
                </router-link>
              </li>
            </ul>
          </span>
        </h2>
        <table>
          <thead>
            <td class="name">{{ $t('name') }}</td>
            <td>{{ $t('places') }}</td>
            <td>{{ $t('price') }}</td>
            <td>{{ $t('date') }}</td>
            <td>{{ $t('time') }}</td>
          </thead>
          <tbody v-if="!shop.spectacles.length">
            <tr>
              <td colspan="5">
                <Spinner v-if="!loaded" :stroke="'#2ecc71'" />
                <p class="empty-list" v-else>{{ $t('noSpectaclesAvailable') }}</p>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr v-for="item in shop.spectacles" :key="item.id">
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
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { toReadableDate } from '@/utils/time-converter';
import { Shop } from '@/types/shops';
import routes from '@/constants/routes';

@Component({
  filters: {
    padded(str: number) {
      return str.toString().padStart(2, '0');
    },
    toReadableDate,
  },
})
export default class ShopDetail extends Vue {
  private loaded: boolean = false;
  private id!: number;
  private shop: Shop | null = null;

  created() {
    this.id = parseInt(this.$route.params.id, 10);
    this.$api.get<Shop>(routes.SHOP(this.id))
      .then(({ data }) => {
        this.loaded = true;
        this.shop = data;
      })
      .catch(() => {
        this.$notify({
          text: this.$tc('errors.shopNotFound'),
          group: 'notifications',
          type: 'error',
        });
      });
  }
}
</script>

<style lang="scss" scoped>
.shop-detail {
  margin: 20px;

  h1, h2 {
    text-align: left;
  }

  h1 {
    margin: 20px 0;
  }

  .shop-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;

    > a {
      text-align: left;
      margin: 0 ;
    }

    ul {
      display: inline-flex;

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

    .spectacles {
      h2 {
        margin: 15px 0;

        > span {
          margin-right: 10px;
          font-size: 16px;

          &:first-child {
            opacity: .5;
          }
        }
      }

      table {
        margin: 20px 0;
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
}
</style>
