import { userLogin, userLogout } from "../actions/authActions";
import { createSlice } from "./createSlice";

const initialState = {
    loading: false,
    userInfo: null,
    userToken: null,
    error: null,
    errors: {},
    success: false
};

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: (create) => ({
        login: userLogin(create),
        logout: userLogout(create),
        setCredentials: (state, { payload }) => {
            state.userInfo = payload;
        },
    }),
});

export const { login, logout, setCredentials } = authSlice.actions;
export default authSlice.reducer;
