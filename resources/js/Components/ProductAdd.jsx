import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import CustomSelect from '../Components/CustomSelect';
import InputError from '../Components/InputError';
import { toast } from 'react-toastify';
import { BeatLoader } from 'react-spinners';
import { Modal } from "react-bootstrap";

const ProductAdd = ({ show, handleClose }) => {
    const [selectedWageType, setSelectedWageType] = useState('')
    const [loading, setLoading] = useState(false)

     // react form hook
    const {
        reset,
        register,
        setValue,
        control,
        formState: { errors },
        handleSubmit,
        trigger,
        setError,
        clearErrors
    } = useForm();

    // handle every select option change 
    const onSelectOptionChange = (setSelectedOption, value, inputName) => { 
        setSelectedOption(value)
        setValue(
            inputName,
            value ? value.value : "",
            { shouldValidate: true }
        );
    }

    // full form reseter
    const formReset = () => {
        reset()
        setSelectedWageType("")
    }

    const onSubmit = (data) => {  
        setLoading(true)

        window.axios
            .post(`/products`, data)
            .then((resp) => {
                handleClose(false)
                setLoading(false)
                if (resp.status === 204) {
                    formReset(); // reset full form
                    toast.success("Product Create successfully");
                } else {
                    toast.error("Something went wrong");
                }
            })
            .catch((error) => {
                setLoading(false)
                if (error.response) {
                    const errors = error.response.data?.errors                
                    toast.error(error.response.data?.message)
                    Object.keys(errors).map((key) => {
                        setError(key, {
                            message: errors[key][0],
                        });
                    });
                }
            });
    }

    if (loading) return (
        <div className="vh-100 d-flex py-4 justify-content-center align-items-center">
            <BeatLoader loading={loading} color="#36d7b7" />
        </div>
    )
    return (
        <Modal
            show={show}
            onHide={handleClose}
            className="modalbox"
            id="ModalForm"
            data-bs-backdrop="static"
            tabIndex="-1"
            aria-modal="true"
            role="dialog"
        >
            <Modal.Header className='card-header'>
                <h5 className="modal-title">Add New Product</h5>
                <button className="btn text-white p-0" onClick={handleClose}>
                    Close
                </button>
            </Modal.Header>
            <Modal.Body className="p-2">
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="d-flex flex-column" style={{gap: '10px 0px'}}>
                        <div>
                            <label
                                htmlFor="product_nr"
                                className="form-label">
                                Product Nr
                            </label>                                            
                            <div>
                                <input
                                    {...register(
                                        `product_nr`,
                                        {required: 'This Is Required'}
                                    )}
                                    placeholder="Product Nr"
                                    type="text"
                                    id="product_nr"
                                    className='form-control'
                                />
                                {errors?.product_nr &&
                                    <InputError
                                        message={errors.product_nr.message}
                                    />
                                }
                            </div>
                        </div>
                        <div>
                            <label htmlFor="product_details" className="form-label">Product Details</label>
                            <div>
                                <input
                                    {...register(
                                        `product_details`,
                                        {required: 'This Is Required'}
                                    )}
                                    className="form-control"
                                    placeholder="Product Details"
                                    type="text"
                                    id="product_details"
                                />
                                {errors.product_details &&
                                    <InputError
                                        message={errors.product_details.message}
                                    />
                                }
                            </div>
                        </div>
                        <div>
                            <label htmlFor="st_dia" className="form-label">ST Dia</label>
                            <div>
                                <input
                                    {...register(
                                        `st_dia`,                                                    
                                    )}
                                    className="form-control"
                                    placeholder="ST Dia"
                                    type="text"
                                    id="st_dia"
                                />
                                {errors.st_dia &&
                                    <InputError
                                        message={errors.st_dia.message}
                                    />
                                }
                            </div>
                        </div>
                        <div>
                            <label htmlFor="weight" className="form-label">Weight</label>
                            <div>
                                <input
                                    {...register(
                                        `weight`, 
                                        {required: 'This Is Required'}
                                    )}
                                    className="form-control"
                                    placeholder="Weight"
                                    type="text"
                                    id="weight"
                                />
                                {errors.weight &&
                                    <InputError
                                        message={errors.weight.message}
                                    />
                                }
                            </div>
                        </div>
                        <div>
                            <label htmlFor="st_dia_price" className="form-label">St dia price</label>
                            <div>
                                <input
                                    {...register(
                                        `st_dia_price`,                                                    
                                    )}
                                    className="form-control"
                                    placeholder="St dia price"
                                    type="number"
                                    id="st_dia_price"
                                />
                                {errors.st_dia_price &&
                                    <InputError
                                        message={errors.st_dia_price.message}
                                    />
                                }
                            </div>
                        </div>
                        <div>
                            <label htmlFor="wage" className="form-label">Wage</label>
                            <div>
                                <input
                                    {...register(
                                        `wage`,                                                    
                                    )}
                                    className="form-control"
                                    placeholder="Wage"
                                    type="number"
                                    id="wage"
                                />
                                {errors.wage &&
                                    <InputError
                                        message={errors.wage.message}
                                    />
                                }
                            </div>
                        </div>
                        <div >
                            <label htmlFor="wage_type" className="form-label">Wage Type</label>
                            <div>
                                <CustomSelect                                                                                           
                                    options={[
                                        {label: 'Percentage', value:'Percentage'},
                                        {label: 'Fixed', value:'Fixed'},
                                    ]}
                                    name='wage_type'                                
                                    control={control}
                                    isRequired={true}
                                    value={selectedWageType}
                                    onChange={(val) => {
                                        onSelectOptionChange(setSelectedWageType, val, 'wage_type')                                                        
                                    }}
                                />  
                                {errors.wage_type && <InputError message={errors.wage_type.message} /> } 
                                
                            </div>
                        </div>
                        
                        <div className="box-footer mt20 text-end">
                            <button type="submit" className="btn btn-primary w-100" id="saveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </Modal.Body>
        </Modal>
    );
};

export default ProductAdd;