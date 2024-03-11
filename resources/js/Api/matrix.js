import axios from "axios";

export const fetchDnmhData = (publicId) => {
    return axios.get(`/api/dnmh/${publicId}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnmh data', error);
        });
};

export const fetchDnmData = (publicId) => {
    return axios.get(`/api/dnm/${publicId}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnm data', error);
        });
};

export const fetchWellCategories = (publicId) => {

    return axios.get(`/api/control/${publicId}/categories/fact`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
};
