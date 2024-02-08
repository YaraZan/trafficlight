import { createStore } from 'vuex';
import {encryptStorage} from "@/utils/storage.js";

const DINAMOGRAPH_API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL;
const API_KEY =import.meta.env.VITE_DINAMOGRAPH_API_KEY;
// const SELECTED_AI_VERSION = encryptStorage.getItem('aiv')

const store = createStore({
    state() {
        return {
            ai_versions: [],
        };
    },
    getters: {
        getAiVersions: state => {
            return state.ai_versions;
        },
    },
    mutations: {
        setAiVersions(state, versions) {
            state.ai_versions = versions;
        },
    },
    actions: {
        async fetchAiVersions({ commit }) {
            try {
                axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Basic ${API_KEY}`
                    },
                })
                .then(response => {
                    const models = response.data.models

                    commit('setAiVersions', models);

                    if (models.length > 0) {
                        if (encryptStorage.getItem('aiv') !== undefined) return
                        encryptStorage.setItem('aiv', models[0].name)
                    }
                })
            } catch (error) {
                console.error('Ошибка при получении версий:', error);
            }
        },
        setCurrentAiVersion(version) {
            encryptStorage.setItem('aiv', version)
        },
        getCurrentAiVersion() {
            return encryptStorage.getItem('aiv')
        }
    }
});

// Fetch AI versions when the app initializes
store.dispatch('fetchAiVersions');

export default store;
