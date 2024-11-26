
import { onMounted, onBeforeUnmount } from 'vue';

export const clickOutside = {
  beforeMount(el, binding) {
    const clickOutsideHandler = (event) => {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value(event);
      }
    };

    el.clickOutsideHandler = clickOutsideHandler;
    document.addEventListener('click', clickOutsideHandler);
  },
  unmounted(el) {
    document.removeEventListener('click', el.clickOutsideHandler);
  }
};
