import api from './api'

export default {

    getProfile(){
        return api.get('/profile')
    },

    updateProfilePicture(formData) {
        return api.post('/profile/picture', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    changePassword(data){
         return api.post('profile/password',data)
    }


}