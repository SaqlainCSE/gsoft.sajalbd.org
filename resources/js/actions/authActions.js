import axios from "axios";

const currentHost = window.location.host;
const currentProtocol = window.location.protocol;

const backendURL = currentProtocol + "//" +currentHost;

export const userLogin = (create) =>
    create.asyncThunk(
        async (loginData, thunkApi) => {
            try {
                const config = {
                    headers: {
                        "Content-Type": "application/json",
                    },
                };
                const { data } = await axios.post(
                    `${backendURL}/login`,
                    loginData,
                    config
                );
                return data;
            } catch (error) {
                // return custom error message from API if any
                if (error.response && error.response.data.message) {
                    throw thunkApi.rejectWithValue({
                        error: error.response.data.message,
                    });
                } else {
                    throw thunkApi.rejectWithValue({
                        error: error.message,
                    });
                }
            }
        },
        {
            pending: (state) => {
                state.loading = true;
            },
            rejected: (state, action) => {
                state.loading = false;
                state.error = action.payload.error;
            },
            fulfilled: (state, action) => {
                state.loading = false;
                state.userInfo = action.payload
            },
        }
    );

    export const userLogout = (create) =>
    create.asyncThunk(
        async (thunkApi) => {
            try {
                const config = {
                    headers: {
                        "Content-Type": "application/json",
                    },
                };
                const { data } = await axios.post(
                    `${backendURL}/logout`,
                    {},
                    config
                );
                return data;
            } catch (error) {
                // return custom error message from API if any
                if (error.response && error.response.data.message) {
                    throw thunkApi.rejectWithValue({
                        error: error.response.data.message,
                    });
                } else {
                    throw thunkApi.rejectWithValue({
                        error: error.message,
                    });
                }
            }
        },
        {
            pending: (state) => {
                state.loading = true;
            },
            rejected: (state, action) => {
                state.loading = false;
                state.error = action.payload.error;
            },
            fulfilled: (state, action) => {
                state.loading = false;
                state.userInfo = null;
            },
        }
    );
