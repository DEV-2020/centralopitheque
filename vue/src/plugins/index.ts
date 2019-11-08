import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
import Notifications from 'vue-notification';
import VCalendar from 'v-calendar';

Vue.use(VueClipboard);
Vue.use(Notifications);
Vue.use(VCalendar, {
  firstDayOfWeek: 2,
});
