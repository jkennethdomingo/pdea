import { createStore } from 'vuex';
import VuexPersist from 'vuex-persist';
import { state } from './state';
import { mutations } from './mutations';
import { actions } from './actions';

const vuexLocal = new VuexPersist({
    storage: window.localStorage,
    reducer: state => ({
        token: state.token,
        userRole: state.userRole,
        employeeID: state.employeeID,
    })
});

export default createStore({
    state,
    mutations,
    actions,
    plugins: [vuexLocal.plugin]
});

