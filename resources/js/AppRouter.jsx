import React, { useEffect, useState } from "react";
import { Route, Routes } from "react-router-dom";
import Dashboard from "./Pages/Dashboard";
import Product from "./Pages/Product";
import AuthLayout from "./Layouts/AuthLayout";
import GuestLayout from "./Layouts/GuestLayout";
import Login from "./Pages/Auth/Login";
import { useDispatch, useSelector } from "react-redux";
import { setCredentials, logout } from "./slices/authSlice";
import Customer from "./Pages/Customer";
import { BeatLoader } from "react-spinners";
import PosCreate from "./Pages/PosCreate";
import ClientCreate from "./Pages/ClientCreate";
import { ToastContainer } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
import ProductCreate from "./Pages/ProductCreate";
import Booking from "./Pages/Booking";

const AppRouter = () => {
    const dispatch = useDispatch();
    const isAuthenticated = useSelector((state) => state.auth.userInfo);
    const Layout = isAuthenticated ? AuthLayout : GuestLayout;
    let [loading, setLoading] = useState(true);
    const [searchValue, setSearchValue] = useState('');

    useEffect(() => {
        const checkAuthStatus = async () => {
            try {
                const config = {
                    headers: {
                        "Content-Type": "application/json",
                    },
                };
                const { data } = await axios.get(`/api/my-profile`, config);
                dispatch(setCredentials(data));
            } catch (error) {
                dispatch(setCredentials(null));
            }
            setLoading(false)
        };
        checkAuthStatus();
    }, []);

    const onChangeSearchFormHandel = (props) =>{
        setSearchValue(props.target.value);
    }

    if (loading) return (
        <div className="vh-100 d-flex py-4 justify-content-center align-items-center">
            <BeatLoader loading={loading} color="#36d7b7" />
        </div>
    )

    return (
        <Layout onChangeSearchFormHandel={onChangeSearchFormHandel}>
            <Routes>
                <Route path="/app" element={<Dashboard />} />
                <Route path="/app/dashboard" element={<Dashboard />} />
                <Route path="/app/client-create" element={<ClientCreate />} />
                <Route path="/app/pos-create" element={<PosCreate />} />
                <Route path="/app/product-create" element={<ProductCreate/>} />
                <Route path="/app/product" element={<Product searchValue={searchValue}/>} />
                <Route path="/app/customers" element={<Customer searchValue={searchValue}/>} />
                <Route path="/app/booking" element={<Booking />} />
                <Route path="/app/login" element={<Login />} />
            </Routes>
            <ToastContainer />
        </Layout>
    );
};

export default AppRouter;
