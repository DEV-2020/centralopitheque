<template>
  <div
    class="copy-clipboard"
    v-clipboard:copy="copy"
    v-clipboard:success="copySuccess">
    <input ref="text" type="hidden" name="value" :value="text">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
      <path
        :d="path" />
    </svg>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component({
  props: {
    copy: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
  },
})
export default class CopyClipboard extends Vue {
  private path = [
    'M433.941 65.941l-51.882-51.882A48 48 0 0 0',
    '348.118 0H176c-26.51 0-48 21.49-48 48v48H48c-26.51',
    '0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h224c26.51',
    '0 48-21.49 48-48v-48h80c26.51 0 48-21.49 48-48V99.882a48',
    '48 0 0 0-14.059-33.941zM266 464H54a6 6 0 0 1-6-6V150a6',
    '6 0 0 1 6-6h74v224c0 26.51 21.49 48 48 48h96v42a6 6 0',
    '0 1-6 6zm128-96H182a6 6 0 0 1-6-6V54a6 6 0 0 1',
    '6-6h106v88c0 13.255 10.745 24 24 24h88v202a6 6 0 0 1-6',
    '6zm6-256h-64V48h9.632c1.591 0 3.117.632 4.243 1.757l48.368',
    '48.368a6 6 0 0 1 1.757 4.243V112z',
  ].join(' ');

  private text!: string;
  private copy!: string;

  copySuccess(): void {
    this.$notify({
      group: 'notifications',
      text: this.text,
      type: 'success',
    });
  }
}
</script>

<style lang="scss" scoped>
.copy-clipboard {
  margin: 0 10px;
}
svg {
  height: 20px;
  cursor: pointer;

  path {
    transition: opacity .1s ease-in-out, fill .1s;
    fill: $black;
  }

  &:hover path {
    opacity: .5;
    fill: $blue;
  }
}
</style>
