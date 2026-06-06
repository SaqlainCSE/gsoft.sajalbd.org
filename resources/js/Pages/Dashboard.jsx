import React, { useEffect } from "react";
import { useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";

const Dashboard = () => {
    const { userInfo } = useSelector((state) => state.auth);
    const navigate = useNavigate();
    
    useEffect(() => {
        if (!userInfo) {
            navigate("/app/login");
        }
    }, [navigate, userInfo]);

    if(!userInfo){
        return <div>Loading</div>
    }

    const handelToast = () => {
        onBackPressed();
    }

    

    return (
        <div>
            <h2>Home Component</h2>
            <p onClick={handelToast}>Check</p>
        </div>
    );
};

export default Dashboard;
