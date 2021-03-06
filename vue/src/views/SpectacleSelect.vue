<template>
  <div class="spectacle-select">
    <h1>{{ $t('spectacleSelect') }}</h1>
    <h6>({{ checkedSpectacles.length }}/3 max)</h6>
    <form class="content" @submit.prevent="saveSelected">
      <table>
        <thead>
          <td />
          <td class="name">{{ $t('name') }}</td>
          <td>{{ $t('places') }}</td>
          <td>{{ $t('price') }}</td>
          <td>{{ $t('date') }}</td>
          <td>{{ $t('time') }}</td>
        </thead>
        <tbody v-if="!spectacles.length">
          <tr>
            <td colspan="5">
              <p class="empty-list">{{ $t('noSpectaclesAvailable') }}</p>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr v-for="item in spectacles" :key="item.id">
            <td>
              <input
                type="checkbox"
                :disabled="buttonDisabled && !item.checked"
                name="spectacle-selected"
                v-model="item.checked"
                :id="`spectacle-${item.id}`">
            </td>
            <td class="name">{{ item.name }}</td>
            <td>{{ item.places }}</td>
            <td>{{ item.price }}€</td>
            <td>{{ item.date | toReadableDate }}</td>
            <td>{{ item.hours | padded }}:{{ item.minutes | padded }}</td>
          </tr>
        </tbody>
      </table>
      <ButtonActivityIndicator :busy="busy">
        {{ $t('save') }}
      </ButtonActivityIndicator>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Getter, Action } from 'vuex-class';
import ButtonActivityIndicator from '@/components/ButtonActivityIndicator.vue';
import { toReadableDate } from '@/utils/time-converter';
import { Spectacle } from '@/types/spectacles';
import { Shop } from '@/types/shops';
import routes from '@/constants/routes';

type CheckableSpectacle = Spectacle & { checked: boolean };

@Component({
  filters: {
    padded(str: number) {
      return str.toString().padStart(2, '0');
    },
    toReadableDate,
  },
  components: {
    ButtonActivityIndicator,
  },
})
export default class SpectacleSelect extends Vue {
  private spectacles: CheckableSpectacle[] = [];
  private shop!: Shop;
  private busy: boolean = false;

  created() {
    const shopId = parseInt(this.$route.params.id, 10);
    const shop = this.shops.find(el => el.id === shopId);
    if (!shop) {
      return this.$router.replace({ name: 'shops-manage' });
    }
    this.shop = shop;

    this.spectacles = this.availableSpectacles.map(spectacle => ({
      ...spectacle,
      checked: this.shop.spectacles.find(el => el.id === spectacle.id) !== undefined,
    }), []);
  }

  saveSelected() {
    const ids = this.checkedSpectacles.map(el => el.id);
    this.busy = true;
    this.$api.post<Shop>(routes.SET_SHOP_SPECTACLES(this.shop.id), {
      spectacles: ids,
    })
      .then(({ data }) => {
        this.busy = false;
        this.updateShop(data);
        this.$notify({
          group: 'notifications',
          text: 'Successfully updated shop spectacles',
          type: 'success',
        });
        this.$router.replace({
          name: 'shop-detail',
          params: {
            id: this.shop.id.toString(),
          },
        });
      })
      .catch(() => {
        this.$notify({
          type: 'error',
          group: 'notifications',
          text: this.$tc('errors.errorOccurredWhile', undefined, {
            reason: this.$tc('errors.spectacleChoice'),
          }),
        });
      });
  }

  @Action('updateShop', { namespace: 'shops' })
  updateShop!: (shop: Shop) => void;

  @Getter('spectacles', { namespace: 'spectacles' })
  private availableSpectacles!: Spectacle[];
  @Getter('shops', { namespace: 'shops' })
  private shops!: Shop[];

  get checkedSpectacles(): Spectacle[] {
    return this.spectacles.filter(el => el.checked);
  }

  get buttonDisabled(): boolean {
    return this.checkedSpectacles.length >= 3;
  }
}
</script>

<style lang="scss">
.spectacle-select {
  margin: 20px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  .content {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
  }

  h1 {
    margin: 10px 0;
    text-align: left;
  }

  h6 {
    margin: 5px 0;
    text-align: left;
    opacity: .8;
  }

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
</style>
