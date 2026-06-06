import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import AppRouter from "./AppRouter";
import { Provider } from "react-redux";
import store from "./store";

ReactDOM.createRoot(document.getElementById("root")).render(
    <Provider store={store}>
        <BrowserRouter>
            <AppRouter />
        </BrowserRouter>
    </Provider>
);
