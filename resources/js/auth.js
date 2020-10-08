register(context, data) {
    axios.post(BASE_URL + '/api/register', data).then((result) => {
        context.commit("setUser", result.data.user);
        context.commit("setToken", result.data.token);
    }).catch(error => {
        console.log(`Error! HTTP Status: ${error}`);
    });
}

const state = {
    user: null,
    token: window.localStorage.getItem('token')
}
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setToken(state, token) {
        window.localStorage.setItem('token', token);
    }
}