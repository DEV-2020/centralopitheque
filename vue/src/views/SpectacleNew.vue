<template>
  <div class="spectacle-new">
    <h1>{{ $t('spectacleNew') }}</h1>
    <form @submit.prevent="newSpectacle">
      <div class="row">
        <label for="name">{{ $t('name') }}: </label>
        <input v-model="name" type="text" id="name">
      </div>
      <div class="row">
        <label for="price">{{ $t('price') }}(€): </label>
        <input v-model="price" type="number" step=".01" min="0" id="price">
      </div>
      <div class="row">
        <label for="price">{{ $t('date') }}: </label>
        <v-date-picker
          :popover="{ visibility: 'click' }"
          mode="single"
          :min-date="new Date()"
          v-model="date" />
      </div>
      <div class="row">
        <label for="hours">{{ $t('time') }}: </label>
        <select v-model="hours" name="hours" id="hours">
          <option v-for="(_, i) in 24" :key="i" :value="i">
            {{ i.toString().padStart(2, '0') }}
          </option>
        </select>
        <span>:</span>
        <select v-model="minutes" name="minutes" id="minutes">
          <option v-for="(_, i) in 60" :key="i" :value="i">
            {{ i.toString().padStart(2, '0') }}
          </option>
        </select>
      </div>
      <div class="row">
        <label for="places">{{ $t('places') }}: </label>
        <input v-model="places" disabled type="number" id="places">
      </div>
      <div class="row">
        <ButtonActivityIndicator :busy="busy">{{ $t('add') }}</ButtonActivityIndicator>
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Spectacle } from '@/types/spectacles';
import { toPhpDate } from '@/utils/time-converter';
import ButtonActivityIndicator from '@/components/ButtonActivityIndicator.vue';
import routes from '@/constants/routes';

interface NewSpectacleData {
  name: string;
  price: number;
  places: number;
  hours: number;
  minutes: number;
  date?: string;
}

@Component({
  components: {
    ButtonActivityIndicator,
  },
})
export default class SpectacleNew extends Vue {
  private name: string = '';
  private price: number = 0;
  private date: Date = new Date();
  private hours: number = 20;
  private minutes: number = 0;
  private places: number = 30;

  private busy: boolean = false;

  newSpectacle() {
    const postData: NewSpectacleData = (({
      name, price, places, hours, minutes,
    }) => ({
      name, price, places, hours, minutes,
    }))(this);

    postData.date = toPhpDate(this.date);

    this.busy = true;
    this.$api.post<Spectacle>(routes.SPECTACLE_NEW, postData)
      .then(() => {
        this.busy = false;
        this.$router.replace({ name: 'spectacles-manage' });
        this.$notify({
          group: 'notifications',
          text: this.$tc('spectacleCreated'),
          type: 'success',
        });
      })
      .catch(() => {
        this.$notify({
          type: 'error',
          group: 'notifications',
          text: this.$tc('errors.errorOccurredWhile', undefined, {
            reason: this.$tc('errors.creatingSpectacle'),
          }),
        });
      });
  }
}
</script>

<style lang="scss" scoped>
.spectacle-new {
  display: flex;
  flex-direction: column;
  margin: 20px;
  align-items: flex-start;

  h1 {
    text-align: left;
    margin: 20px 0;
  }

  form {
    display: inline-flex;
    flex-direction: column;
    align-items: center;

    .row {
      margin: 5px 0;
      display: flex;
      flex-direction: row;
      align-items: center;
      width: 100%;

      label {
        display: inline-block;
        text-align: left;
        min-width: 70px;
      }
    }

    input {
      padding: 8px;
      box-sizing: border-box;
      width: 300px;
      border-radius: 4px;
      border: solid 1px #cbd5e0;
      font-size: 16px;
      line-height: 1.25;
    }

    select {
      border-radius: 4px;
      padding: 8px;
      padding-right: 20px;
      font-size: 16px;
      line-height: 1.25;
      box-sizing: border-box;
      border: solid 1px #cbd5e0;
      appearance: none;
      background: url('~@/assets/svg/caret-down.svg');
      background-repeat: no-repeat;
      background-position: 80% 50%;
      background-size: 10px;

      & + span {
        margin: 0 10px;
      }
    }

    ::v-deep .vc-appearance-none {
      box-sizing: border-box;
      width: 300px;
    }

    button[type=submit] {
      background-color: $primary;
      border-radius: 5px;
      padding: 5px 10px;
      color: $white;
      border: solid 0px;
      font-size: 16px;
      font-family: 'Avenir';
      cursor: pointer;
      margin: 10px auto;
      font-weight: 500;
    }
  }
}
</style>
