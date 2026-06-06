import React, { useEffect, useState } from "react";
import { login } from "../../slices/authSlice";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import Checkbox from "@/Components/Checkbox";

const Login = () => {
    const dispatch = useDispatch();
    const { userInfo, error, loading } = useSelector((state) => state.auth);
    const navigate = useNavigate();
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [remember, setRemember] = useState(false);

    useEffect(() => {
        if (userInfo) {
            navigate("/app");
        }
    }, [navigate, userInfo]);

    const handleLogin = (e) => {
        e.preventDefault();
        dispatch(
            login({
                username: username,
                password: password,
            })
        );
    };

    return (
        <div className="login-form mt-1 px-4">
            <div className="section">
                <img
                    src="../img/sample/photo/vector4.png"
                    alt="image"
                    className="form-image"
                />
            </div>
            <div className="section mt-1">
                <h4>Get started</h4>
            </div>
            <form onSubmit={handleLogin} autoComplete="off">
                <div>
                    <TextInput
                        id="username"
                        type="text"
                        name="username"
                        placeholder="Username"
                        value={username}
                        className="mt-1 block w-full"
                        autoComplete="off"
                        isFocused={true}
                        onChange={(e) => setUsername(e.target.value)}
                    />

                    <InputError message={error} className="mt-2" />
                </div>

                <div className="mt-4">
                    {/* <InputLabel htmlFor="password" value="Password" /> */}

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        value={password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </div>

                <div className="form-links mt-2 mb-2">
                    <div>
                        <label>
                            <Checkbox
                                name="remember"
                                checked={remember}
                                onChange={(e) => setRemember(e.target.checked)}
                            />
                            <span className="ml-1">Remember me</span>
                        </label>
                    </div>
                </div>

                <div>
                    <PrimaryButton className="ms-4" disabled={loading}>
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
};

export default Login;
