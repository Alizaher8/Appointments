import { defineStore } from "pinia";
import { ref } from 'vue';
import { useStorage } from '@vueuse/core'


export const useThemeStore = defineStore('ThemeStore', () => {

 const theme = useStorage('ThemeStore:theme',ref('light'));

  const changeTheme = () => {

     theme.value = theme.value === 'light' ? 'dark' : 'light';
  };

    return { theme, changeTheme };

});
