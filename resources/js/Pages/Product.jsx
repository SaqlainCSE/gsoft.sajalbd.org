import React, { useEffect, useState } from "react";
import { useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import ProductListItem from "../Components/ProductListItem";
import { InView } from "react-intersection-observer";
import { BeatLoader } from "react-spinners";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import ProductAdd from "../Components/ProductAdd";

const Product = ({searchValue}) => {
    const { userInfo } = useSelector((state) => state.auth);
    const navigate = useNavigate();
    let [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);
    const [products, setProducts] = useState([]);
    const [isShowCustomerAdd, setIsShowCustomerAdd] = useState(false);

    const handleCloseCustomerAdd = () => {
        console.log('click')
        setIsShowCustomerAdd(!isShowCustomerAdd);
    }

    const handelInView = (inView) => {
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
        axios.get("/api/products?forApp&page=" + currentPage).then((resp) => {
            setProducts([...products, ...resp.data.data]);
            console.log(resp.data.data)
            if (resp.data?.meta?.last_page) {
                setLastPage(resp.data?.meta?.last_page);
            }
            setLoading(false);
        });
    }, [currentPage]);
    
    useEffect(() => {
        axios.get("/api/products?forApp&page=1&search=" + searchValue).then((resp) => {
            setProducts(resp.data.data);
            if (resp.data?.meta?.last_page) {
                setLastPage(resp.data?.meta?.last_page);
            }
        });
    }, [searchValue]);

    return (
        <>
            <ProductAdd show={isShowCustomerAdd} handleClose={handleCloseCustomerAdd}/>
            <div className="listview-title mt-2">
                Products
                 <div role="button"  onClick={handleCloseCustomerAdd} className="fab">
                    <FontAwesomeIcon
                        icon={faPlus}
                        style={{ fontSize: "26px" }}
                    />
                </div>
            </div>
            <div className="px-2">
                {products.map((item, index) => {
                    return <ProductListItem item={item} key={index} />
                })}
            </div>
            <InView as="div" onChange={(inView, entry) => handelInView(inView)}>
                <div className="d-flex py-4 justify-content-center">
                    <BeatLoader loading={loading} color="#36d7b7" />
                </div>
            </InView>
        </>
    );
};

export default Product;
