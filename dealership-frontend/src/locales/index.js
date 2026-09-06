import { createI18n } from 'vue-i18n'

import en from './en'
import fr from './fr'
import ar from './ar'

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('language') || 'en',
    fallbackLocale: 'en',

    messages: {
        en,
        fr,
        ar
    }
})

/* The Direction of the Text */
const updateDocumentDirection = (language) => {
    document.documentElement.lang = language
    document.documentElement.dir = language === 'ar' ? 'rtl' : 'ltr'
}
updateDocumentDirection(i18n.global.locale.value)


export default i18n