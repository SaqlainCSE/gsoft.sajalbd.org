import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import CustomSelect from '../Components/CustomSelect';
import InputError from '../Components/InputError';
import { toast } from 'react-toastify';
import { BeatLoader } from 'react-spinners';

const ClientCreate = () => {
     // Form Select Input Fields options loading
    const [selectInputOptionsLoading, setSelectInputOptionsLoading] = useState(false)
    const [loading, setLoading] = useState(false)

    // others Selected Input field options 
    const [selectInputOptions, setSelectInputsOptions] = useState([])
    const [zoneSelectInputOptions, setZoneSelectInputsOptions] = useState([])

    // selected Value
    const [selectedCategory, setSelectedCategory] = useState("")
    const [selectedDistrict, setSelectedDistrict] = useState("")
    const [selectedZone, setSelectedZone] = useState(" ")

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

    // Loading Select Input Options list for select options
    useEffect(() => {
        setSelectInputOptionsLoading(true)
        axios.get('/clients/create', {
            headers: {
                Accept: 'application/json'
            }
        })
            .then((response) => {
                const data = response.data
                let newData = {}
                console.log(data);
                Object.keys(data).map(key => {
                    const item = data[key]
                    Object.keys(item).map(itemKey => { 
                        if (!newData[key]) {
                            // If not, initialize it with an empty array
                            newData[key] = [];
                        }
                        newData[key].push({label: item[itemKey], value: itemKey})
                    })
                })
                setSelectInputsOptions(newData) 
                setSelectInputOptionsLoading(false)          
            })
            .catch((error) => {
                console.log(error);
                setSelectInputOptionsLoading(false)  
            });
    }, [])

    // Loading Zone list for select options
    useEffect(() => {
        if (selectedDistrict?.value) {
            setSelectInputOptionsLoading(true)
            axios.get(`/select2-zone?_type=query&district_id=${selectedDistrict?.value}`)
                .then((response) => {
                console.log( response.data?.results)
                const data = response.data?.results?.map((item) => {
                    return {
                        label: item.text,
                        value : item.id
                    }
                })
                setZoneSelectInputsOptions(data)
                setSelectInputOptionsLoading(false)
            })
            .catch((error) => {
                setSelectInputOptionsLoading(false)
                console.log(error);
            });
        }
    }, [selectedDistrict])

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
        setSelectedCategory("")
        setSelectedDistrict("")
        setSelectedZone("")
    }

    const onSubmit = (data) => {  
        setLoading(true)
        const formData = new FormData();
        Object.keys(data).map((key) => {
            if (key === "picture") {
                formData.append("picture", data.picture[0]);
            } else {
                formData.append(key, data[key]);
            }
        });

        window.axios
            .post(`/clients`, formData)
            .then((resp) => {
                setLoading(false)
                if (resp.status === 204) {
                    formReset(); // reset full form
                    toast.success("Created Client successfully");
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
        <div>
            <div className="row p-2">
                <div className="col-lg-12" >
                    <div className="card" >
                        <div className="card-header">
                            <p className="card-title">Create Client</p>
                        </div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit(onSubmit)}>
                                <div className="d-flex flex-column" style={{gap: '10px 0px'}}>
                                    <div>
                                        <label
                                            htmlFor="mobile_number"
                                            className="form-label">
                                            Mobile Number
                                        </label>                                            
                                        <div>
                                            <input
                                                {...register(
                                                    `mobile_number`,
                                                    {required: 'This Is Required'}
                                                )}
                                                placeholder="Mobile Number"
                                                type="tel"
                                                id="mobile_number"
                                                className='form-control parsley-error'
                                            />
                                            {errors?.mobile_number &&
                                                <InputError
                                                    message={errors.mobile_number.message}
                                                />
                                            }
                                        </div>
                                    </div>
                                    <div>
                                        <label htmlFor="name" className="form-label">Name</label>
                                        <div>
                                            <input
                                                {...register(
                                                    `name`,
                                                    {required: 'This Is Required'}
                                                )}
                                                className="form-control"
                                                placeholder="Name"
                                                type="text"
                                                id="name"
                                            />
                                            {errors.name &&
                                                <InputError
                                                    message={errors.name.message}
                                                />
                                            }
                                        </div>
                                    </div>
                                    <div>
                                        <label htmlFor="fb_name" className="form-label">FB name</label>
                                        <div>
                                            <input
                                                {...register(
                                                    `fb_name`,                                                    
                                                )}
                                                className="form-control"
                                                placeholder="FB Name"
                                                type="text"
                                                id="fb_name"
                                            />
                                            {errors.fb_name &&
                                                <InputError
                                                    message={errors.fb_name.message}
                                                />
                                            }
                                        </div>
                                    </div>
                                    <div >
                                        <label htmlFor="customer_category_id" className="form-label">Customer Category</label>
                                        <div>
                                            <CustomSelect                                                                                           
                                                options={selectInputOptions?.categories}
                                                name='category'                                
                                                control={control}
                                                isLoading={selectInputOptionsLoading}
                                                value={selectedCategory}
                                                onChange={(val) => {
                                                    onSelectOptionChange(setSelectedCategory, val, 'category')                                                        
                                                }}
                                            />  
                                            {errors.category && <InputError message={errors.category.message} /> } 
                                            
                                        </div>
                                    </div>
                                    <div >
                                        <label htmlFor="district_id" className="form-label">District</label>
                                        <div>
                                            <CustomSelect                                                                                           
                                                options={selectInputOptions?.districts}
                                                name='district_id'                                
                                                control={control}
                                                isLoading={selectInputOptionsLoading}
                                                value={selectedDistrict}
                                                onChange={(val) => {
                                                    onSelectOptionChange(setSelectedDistrict, val, 'district_id')                                                        
                                                }}
                                            />  
                                            {errors.district_id && <InputError message={errors.district_id.message} /> } 
                                            
                                        </div>
                                    </div>
                                    <div >
                                        <label htmlFor="zone_id" className="form-label">Zone</label>
                                        <div>
                                            <CustomSelect                                                                                           
                                                options={zoneSelectInputOptions}
                                                name='zone_id'                                
                                                control={control}
                                                isLoading={selectInputOptionsLoading}
                                                value={selectedZone}
                                                onChange={(val) => {
                                                    onSelectOptionChange(setSelectedZone, val, 'zone_id')                                                        
                                                }}
                                            />  
                                            {errors.zone_id && <InputError message={errors.zone_id.message} /> } 
                                            
                                        </div>
                                    </div>
                                    <div >
                                        <label htmlFor="address" className="form-label">Address</label>
                                        <div>                                                
                                            <textarea
                                                {...register(
                                                    `address`,
                                                )}
                                                rows="2"
                                                className="form-control"
                                                placeholder="Address"
                                                cols="50"
                                                id="address"
                                                spellCheck="false"
                                            >                                                
                                            </textarea>
                                            {errors.address && <InputError message={errors.address.message} /> } 
                                        </div>
                                    </div>
                                    <div >
                                        <label htmlFor="picture" className="form-label">Picture</label>
                                        <div>                                            
                                            <input
                                                {...register(
                                                    `picture`,
                                                )}
                                                className="form-control"
                                                type="file"
                                                id="picture"
                                            />
                                            {errors.picture && <InputError message={errors.picture.message} /> }
                                        </div>
                                    </div>
                                    <div className="box-footer mt20 text-end">
                                        <button type="submit" className="btn btn-primary w-100" id="saveBtn">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ClientCreate;