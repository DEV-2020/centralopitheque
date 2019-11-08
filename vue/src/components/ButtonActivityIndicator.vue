<template>
  <button :type="buttonType" :class="[color, { busy }]">
    <slot v-if="!busy" />
    <Spinner v-else />
  </button>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import Spinner from '@/components/Spinner.vue';

@Component({
  components: {
    Spinner,
  },
  props: {
    color: {
      required: false,
      default: 'green',
    },
    busy: {
      required: true,
    },
    buttonType: {
      required: false,
      default: 'submit',
    },
  },
})
export default class ButtonActivityIndicator extends Vue {
  private color!: string;
  private busy!: boolean;
  private buttonType!: string;
}
</script>

<style lang="scss" scoped>
button {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 5px;
  padding: 5px 10px;;
  color: $white;
  border: solid 0px;
  font-size: 16px;
  font-family: 'Avenir';
  cursor: pointer;
  margin: 10px auto;
  font-weight: 500;
  transition: background-color .3s, opacity .3s;

  &.green {
    background-color: $primary;
  }

  &.red {
    background-color: $error;
  }

  &.blue {
    background-color: $blue;
  }

  &.busy {
    opacity: .3;
  }
}

.spinner {
  height: 20px;
}
</style>
