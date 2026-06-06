import axios from "axios";
import React, { useEffect, useState, useRef } from "react";
import { useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import ClientListItem from "../Components/ClientListItem";
import { BeatLoader } from "react-spinners";
import { InView } from "react-intersection-observer";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import CustomerAdd from "../Components/CustomerAdd";

const Customer = ({searchValue}) => {
    const navigate = useNavigate();
    const { userInfo } = useSelector((state) => state.auth);
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);
    const [clients, setClients] = useState([]);
    const [isShowCustomerAdd, setIsShowCustomerAdd] = useState(false);

    const handleInView = (inView) => {
        // console.log("Inview: " + inView);
        if (inView && currentPage < lastPage) {
            setCurrentPage(currentPage + 1);
        }
    };

    useEffect(() => {
        if (!userInfo) {
            navigate("/app/login");
        }
    }, [navigate, userInfo]);

    useEffect(() => {
        setLoading(true);
        axios.get("/api/clients?forApp&page=" + currentPage).then((resp) => {
            setClients([...clients, ...resp.data.data]);
            if (resp.data?.meta?.last_page) {
                setLastPage(resp.data?.meta?.last_page);
            }
            setLoading(false);
        });
    }, [currentPage]);

    const handleCloseCustomerAdd = () => {
        setIsShowCustomerAdd(!isShowCustomerAdd);
    }

    useEffect(() => {
        setLoading(true);
        axios.get("/api/clients?forApp&page=1&search=" + searchValue).then((resp) => {
            setClients(resp.data.data);
            console.log(resp.data.data);
            if (resp.data?.meta?.last_page) {
                setLastPage(resp.data?.meta?.last_page);
            }
            setLoading(false);
        });
    }, [searchValue]);

    return (
        <div>
            <CustomerAdd show={isShowCustomerAdd} handleClose={handleCloseCustomerAdd}/>
            <div className="listview-title mt-2">
                Customers
                <div role="button" onClick={handleCloseCustomerAdd} className="fab" >
                    <FontAwesomeIcon
                        icon={faPlus}
                        style={{ fontSize: "26px" }}
                    />
                </div>
            </div>
            <ul className="listview image-listview">
                {clients?.map((item, index) => <ClientListItem item={item} key={index} /> )}
            </ul>
            <InView as="div" onChange={(inView, entry) => handleInView(inView)}>
                <div className="d-flex py-4 justify-content-center">
                    <BeatLoader loading={loading} color="#36d7b7" />
                </div>
            </InView>
        </div>
    );
};

export default Customer;
