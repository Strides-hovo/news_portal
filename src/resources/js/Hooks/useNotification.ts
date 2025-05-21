
import {useEchoPublic} from '@laravel/echo-vue'
import {ref} from "vue";

export default function useNotification() {

    const userName = ref(null)
    useEchoPublic('registered','UserRegisteredEvent', (e) => {
        userName.value = e
        console.log('Подключение к каналу:', e);
    })

    return userName
}
