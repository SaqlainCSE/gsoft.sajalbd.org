import { useEffect, useState } from "react";
import Modal from "react-bootstrap/Modal";
import { useDispatch, useSelector } from "react-redux";
import { Link, useLocation } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faBars,
    faMagnifyingGlass,
    faHouse,
    faUserGroup,
    faGem,
    faXmark,
    faArrowRightFromBracket,
    faClose,
} from "@fortawesome/free-solid-svg-icons";
import { logout } from "../slices/authSlice";

const AuthLayout = ({ children, onChangeSearchFormHandel }) => {
    let location = useLocation();
    const [showSearchForm, setShowSearchForm] = useState(false);

    const { userInfo } = useSelector((state) => state.auth);
    const dispatch = useDispatch();

    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    const handelLogout = () => {
        dispatch(logout());
    };

    useEffect(() => {
        const closeModal = () => {
            setTimeout(() => {
                handleClose();
            }, 300);
        };

        return () => closeModal();
    }, [location]);

    return (
        <>
            <div className="appHeader bg-primary scrolled">
                <div className="left">
                    <span
                        onClick={handleShow}
                        className="headerButton"
                        data-toggle="modal"
                        data-target="#sidebarPanel"
                    >
                        <FontAwesomeIcon
                            icon={faBars}
                            style={{ fontSize: "30px" }}
                        />
                    </span>
                </div>
                <div className="pageTitle">Discover</div>
                <div className="right">
                    <span
                        className="headerButton toggle-searchbox"
                        onClick={() => setShowSearchForm(!showSearchForm)}
                    >
                        <FontAwesomeIcon
                            icon={faMagnifyingGlass}
                            style={{ fontSize: "30px" }}
                        />
                    </span>
                </div>
            </div>
            <div
                className="appCapsule"
                style={{ paddingTop: "70px", paddingBottom: "57px" }}
            >
                {children}
            </div>
            <div className="appBottomMenu">
                <Link to="/app" className="item active">
                    <div className="col">
                        <FontAwesomeIcon icon={faHouse} />
                    </div>
                </Link>

                <span onClick={handleShow} className="item">
                    <div className="col">
                        <FontAwesomeIcon icon={faBars} />
                    </div>
                </span>
            </div>

            <Modal
                show={show}
                onHide={handleClose}
                id="sidebarPanel"
                className="panelbox panelbox-left"
            >
                <Modal.Body>
                    <div className="profileBox">
                        <div className="image-wrapper">
                            <img
                                src="/img/sample/avatar/user-dummy.png"
                                alt="image"
                                className="imaged rounded"
                            />
                        </div>
                        <div className="in">
                            <strong>{userInfo?.name}</strong>
                        </div>
                        <span
                            className="close-sidebar-button"
                            onClick={handleClose}
                        >
                            <FontAwesomeIcon icon={faXmark} />
                        </span>
                    </div>
                    <ul className="listview flush transparent no-line image-listview">
                        <li>
                            <Link to="/app/customers" className="item pl-0">
                                <div className="icon-box bg-primary">
                                    <FontAwesomeIcon icon={faUserGroup} />
                                </div>
                                <div className="in">Customers</div>
                            </Link>
                        </li>
                        <li>
                            <Link to="/app/product" className="item pl-0">
                                <div className="icon-box bg-primary">
                                    <FontAwesomeIcon icon={faGem} />
                                </div>
                                <div className="in">
                                    <div>Products</div>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link to="/app/pos-create" className="item pl-0">
                                <div className="icon-box bg-primary">
                                    <FontAwesomeIcon icon={faGem} />
                                </div>
                                <div className="in">
                                    <div>Sell</div>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link to="/app/booking" className="item pl-0">
                                <div className="icon-box bg-primary">
                                    <FontAwesomeIcon icon={faGem} />
                                </div>
                                <div className="in">
                                    <div>Booking</div>
                                </div>
                            </Link>
                        </li>
                    </ul>
                </Modal.Body>
                <Modal.Footer>
                    <div className="sidebar-buttons">
                        <span className="button">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span className="button">
                            <ion-icon name="archive-outline"></ion-icon>
                        </span>
                        <span className="button">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span className="button" onClick={handelLogout}>
                            <FontAwesomeIcon icon={faArrowRightFromBracket} />
                        </span>
                    </div>
                </Modal.Footer>
            </Modal>

            <div
                id="search"
                className={`appHeader` + (showSearchForm ? ` show` : ``)}
            >
                <form className="search-form">
                    <div className="form-group searchbox">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Search..."
                            onKeyUp={onChangeSearchFormHandel}
                        />
                        <i className="input-icon">
                            <ion-icon
                                name="search-outline"
                                role="img"
                                className="md hydrated"
                                aria-label="search outline"
                            ></ion-icon>
                        </i>
                        <a
                            href="#"
                            className="ms-1 close toggle-searchbox"
                            onClick={() => setShowSearchForm(!showSearchForm)}
                        >
                            <FontAwesomeIcon icon={faClose} />
                        </a>
                    </div>
                </form>
            </div>
        </>
    );
};

export default AuthLayout;
