import React, { useEffect, useState } from 'react';
import ProductCard from '../Components/ProductCard';
import CustomSelect from '../Components/CustomSelect';
import PaymentCard from '../Components/PaymentCard';
import {useFieldArray, useForm } from 'react-hook-form';
import PaymentCardBody from '../Components/PaymentCardBody';
import PosCreateTotalInfoCard from '../Components/PosCreateTotalInfoCard';
import axios from 'axios';
import InputError from '../Components/InputError';
import { toast } from 'react-toastify';

const PosCreate = () => {
    // others Selected Input field options 
    const [selectInputOptions, setSelectInputsOptions] = useState([])
    const [products, setProducts] = useState([])
    const [clients, setClients] = useState([])

    // form select input field selected option or value
    const [selectedProducts, setSelectedProducts] = useState([])
    const [selectedProductNr, setSelectedProductNr] = useState('')
    const [selectedSalesType, setSelectedSalesType] = useState('')
    const [selectedClient, setSelectedClient] = useState('')   
    const [selectedSaleBy, setSelectedSaleBy] = useState('') 
    
    // Form Select Input Fields options loading
    const [selectInputOptionsLoading, setSelectInputOptionsLoading] = useState(false)
    const [productsLoading, setProductsLoading] = useState(false)
    const [clientLoading, setClientLoading] = useState(false)

    // Product card info states
    const [totalSubTotal, setTotalSubTotal] = useState(0)
    const [subTotalValues, setSubtotalValues] = useState([])
    const [totalWeight, setTotalWeight] = useState(0)
    const [weightValues, setWeightValues] = useState([])
    const [totalStDia, setTotalStDia] = useState(0)
    const [stDiaValues, setStDiaValues] = useState([])

    //payment Info States
    const [totalDueAmount, setTotalDueAmount] = useState("")
    const [totalAmountToPaid, setTotalAmountToPaid] = useState(0)
    const [totalPayAmount, setTotalPayAmount] = useState(0)
    const [payAmountValues, setPayAmountsValues] = useState([])

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

     const payment = {
        payment: '',
        payment_info: '',
        reference: '',
        amount: '',
     }
    
    // this is for payment card input fields
    const { fields, append, remove } = useFieldArray({
        control,
        name: "payments",
    });

    // this is for product card input fields
    const productField = {
        weight: '',
        wage: '',
        st_dia_price: '',
        unit_price: '',
    }
    const { fields : productFields, append : productFieldAppend, remove : productFieldRemove } = useFieldArray({
        control,
        name: "products",
    });
   
    // set defaults fields array
    useEffect(() => {
        append(payment);
    }, []);

    // set defaults value to due input field
    useEffect(() => {
        setTotalDueAmount(totalAmountToPaid - totalPayAmount || "")
    }, [totalAmountToPaid, totalPayAmount]);

    const dummyData = {
        options: {
            salesTypes: [
                { label: 'NORMAL', value: 'normal' },
                { label: 'BOOKING SALE', value: 'booking sale' }
            ],
            clint: [
                { label: 'md tusher (01643613878)', value: 'md tusher (01643613878)' }
            ],
            productNr: [
                { label: 'BNG-013 (2.87)', value: 'BNG-013 (2.87)', product_nr: 'BNG-013' },
                { label: 'BNG-031 (2.87)', value: 'BNG-031 (2.87)', product_nr: 'BNG-031' },
                { label: 'BNG-045 (2.87)', value: 'BNG-045 (2.87)', product_nr: 'BNG-045' },
                { label: 'BNG-054 (2.87)', value: 'BNG-054 (2.87)', product_nr: 'BNG-054' },
            ],
            vat: [
                {label: '5%', value: '5%'}
            ],
            payment_type: [
                {label: 'Cash', value: 'cash'},
                {label: 'Card', value: 'card'},
            ],
            payment_info: [
                {label: 'CASH', value: 'cash'},
                {label: 'ADVANCE', value: 'advance'},
                {label: 'SALES RETURN', value: 'sales return'},
            ],
        }
    }
    
    // Loading Products list for select options
    // useEffect(() => {
    //     setProductsLoading(true)
    //     axios.get('/select2-product')
    //     .then( (response) =>{
    //         const data = response.data?.results?.map((item) => {
    //             return {
    //                 label: item.text,
    //                 value : item.id
    //             }
    //         })
    //         setProducts(data)
    //         setProductsLoading(false)
    //     })
    //     .catch((error) => {
    //         setProductsLoading(false)
    //         console.log(error);
    //     });
    // }, [])

    // Loading Select Input Options list for select options
    useEffect(() => {
        setSelectInputOptionsLoading(true)
        axios.get('/pos/create', {
            headers: {
                Accept: 'application/json'
            }
        })
            .then((response) => {
                const data = response.data
                let newData = {}
                // console.log(data);
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
    
    // Loading Client list for select options
    useEffect(() => {
        setClientLoading(true)
        axios.get('/select2-client')
        .then((response) => {
            const data = response.data?.results?.map((item) => {
                return {
                    label: item.text,
                    value : item.id
                }
            })
            setClients(data)
            setClientLoading(false)                
        })
        .catch((error) => {
            console.log(error);
            setClientLoading(false)
        });
    },[])

    const totalCalculator = (list) => {
        const sum = list.reduce((accumulator, currentNumber) => accumulator + parseFloat(currentNumber), 0);            
        if (sum === 0) {
            return ""
        }
        return sum.toFixed(2)
    }

    // set New Total Sub-Total
    useEffect(() => {         
        setTotalSubTotal(totalCalculator(subTotalValues))        
    }, [subTotalValues])
    
     // set New Weight Total
    useEffect(() => {     
        setTotalWeight(totalCalculator(weightValues))
    },[weightValues])

    // on select product event
    // load selected product details and
    // add a product card with details and required input fields
    const handleProductNrChange = (product) => { 
        //test: future need
        // checking is that the same item selected! then returning
        // if (selectedProducts?.find(item => item.id === product.id)) return
        
        // Load single Product details
        if (product?.value) {
            axios.get(`/products/${product?.value}`)
            .then((response) => {     
                setSelectedProducts(current => [...current, response.data]) // set this product on selected products list
                productFieldAppend(productField) // add a new product card 
            })
            .catch((error) => {
                console.log(error);
            });        
        
            setSelectedProductNr('') // reset the the value of select
        }
    }

    // handle product card remove
    // also handles total info change on product card remove
    const handleCancelProduct = (index, product) => { 
        // remove the sub total value of this product from the list
        let currentSubTotalValues = [...subTotalValues]
        currentSubTotalValues.splice(index, 1)
        setSubtotalValues(currentSubTotalValues)

        // remove the weight value  of this product from the list
        let currentWeightValues = [...weightValues]
        currentWeightValues.splice(index, 1)
        setWeightValues(currentWeightValues)
        
        // remove the weight value  of this product from the list
        let currentStDiaValues = [...stDiaValues]
        currentStDiaValues.splice(index, 1)
        setStDiaValues(currentStDiaValues)
        

        productFieldRemove(index) // remove the product from the list
        const items = selectedProducts.filter(item => item.id !== product.id) // find and remove the product
        setSelectedProducts(items) // set the new list selected products
    }

    // Set all product card weight input value to the array
    // then call the totalCalculator to calculate
    const totalWeightCount = (value, index) => { 
        let currentValues = [...weightValues]
        const isThisIndexHasValue = currentValues[index] ?? false
        // console.log(value)
        if (value) {
            if (isThisIndexHasValue) {
                currentValues[index] = value 
                setWeightValues(currentValues) 
            }else { 
                currentValues.splice(index, 0, value)
                setWeightValues(currentValues)        
            }
        }       
    }

    // Set all product card Subtotal input value to the array
    // then call the totalCalculator to calculate
    const totalSubTotalCount = (value, index) => { 
        let currentValues = [...subTotalValues]
        const isThisIndexHasValue = currentValues[index] ?? false
        if (value) {
            if (isThisIndexHasValue) {
                currentValues[index] = value 
                setSubtotalValues(currentValues) 
            }else { 
                currentValues.splice(index, 0, value)
                setSubtotalValues(currentValues)        
            }
        }
        
        
    }

    // Set all product card st Dia value to the array
    // then call the totalCalculator to calculate
    const totalStDiaCount = (value, index) => { 
        let currentValues = [...stDiaValues]

        const isThisIndexHasValue = currentValues[index] ?? false
        if (value) {
            if (isThisIndexHasValue) {
                currentValues[index] = value 
                setStDiaValues(currentValues) 
            }else { 
                currentValues.splice(index, 0, value)
                setStDiaValues(currentValues)        
            }
        } 
    }
    //? End ------ selected Product card Functions End -----
    


    //? Start ----- Payment Info Functions start -----

    const handleAddPaymentOption = () => { 
         append(payment);
    }
    const cancelPaymentOption = (index) => { 
        remove(index);
        
        // remove the pay amount value from the list
        let currentSubTotalValues = [...payAmountValues]
        currentSubTotalValues.splice(index, 1)
        setPayAmountsValues(currentSubTotalValues)
    }

    // set New Total of Sub-Total
    useEffect(() => {         
        setTotalPayAmount(totalCalculator(payAmountValues))        
    }, [payAmountValues])
    
    // handle change of value of paid amount input field
    const onPaymentAmountChange = (value, index) => { 
        let currentValues = [...payAmountValues]

        const isThisIndexHasValue = currentValues[index] ?? false
        if (value) {
            if (isThisIndexHasValue) {
                currentValues[index] = value 
                setPayAmountsValues(currentValues) 
            }else { 
                currentValues.splice(index, 0, value)
                setPayAmountsValues(currentValues)        
            }
        } 
    } 

    // Handle change return value input value Change
    const handleReturnAmountChange = (amount) => {
        const newDue = totalAmountToPaid - (totalPayAmount - parseFloat(amount || 0))  
        setTotalDueAmount(newDue)        
    }

    const formReset = () => {
        reset();
        setSelectedProducts([])
        setSelectedProductNr('')
        setSelectedSalesType('')
        setSelectedClient('')
        setSelectedSaleBy('')
    }
   
    // handle Form submit
    const onSubmit = (data) => { 
        let formData = new FormData()  //formdata object
       
        Object.keys(data).forEach(key => { 
            if (key === 'products') {
                data[key].map((item, index) => {
                    formData.append('wage['+index+']', item.wage);
                    formData.append('unit_price['+index+']', item.unit_price);
                    formData.append('st_dia_price['+index+']', item.st_dia_price);
                    formData.append('weight['+index+']', item.weight);
                    formData.append('product_id['+index+']', item.id);
                })
            }
            if (key === 'payments') {
                data[key].map((item, index) => {
                    formData.append('payment_info['+index+']', item.payment_info);
                    formData.append('payment['+index+']', item.payment);
                    formData.append('amount['+index+']', item.amount);
                    formData.append('reference['+index+']', item.reference);
                })
            }
            else {
                if (key === 'paid') {
                    formData.append(key, totalPayAmount);
                }
                else if (key === 'due') {
                    formData.append(key, totalDueAmount);
                } else {
                    formData.append(key, data[key]);
                    
                }
            }
        })
        
        axios.post(`/pos`, formData, {
            headers: {
                Accept: 'application/json'
            }
        })
        .then((res) => {     
            if (res.status === 204) {
                toast.success('Pos Create Successfully')
                window.location.reload()
                // formReset()
            } else {
                toast.error("Something went wrong");
            }              
        })
        .catch((error) => {
            console.log(error);
            if (error.response) {
                toast.error(error.response.data?.message);
                Object.keys(error.response.data?.errors).map((key) => {
                    setError(key, {
                        message: error.response.data?.errors[key][0],
                    });
                });
            }
        });
    }

    const [searchTerm, setSearchTerm] = useState('');
    useEffect(() => {
        const fetchData = async () => {            
            try {
                const response = await axios.get(`../select2-product?term=${searchTerm}&labelValue`);
                console.log(response);
                setProducts(response.data.results);
                setProductsLoading(false)
            } catch (error) {
                console.error('Error fetching data:', error);
                setProductsLoading(false)
            }
        };

        // Fetch data only if there's a search term
        if (searchTerm && searchTerm !== "") {
            fetchData();
            setProductsLoading(true)
        } else {
            // Clear options when search term is empty
            setProducts([]);
        }
    }, [searchTerm]);
    return (
        <div className="row p-2 pos-create">
            <div className="col-lg-12">
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="card mb-2">
                        <div className="card-header">
                            <h6 className="card-title ">Create Order</h6>
                        </div>
                        <div className="card-body">
                            <div className="row">
                                <div className="col-12 col-md-12" >
                                    <div className="row">
                                        <div className="col-md-4">
                                            <label htmlFor="sale_type_id" className="col-form-label text-start">Sale By</label>
                                            <CustomSelect
                                                name="sale_by"
                                                options={selectInputOptions?.users}
                                                control={control}
                                                value={selectedSaleBy}
                                                isLoading={selectInputOptionsLoading}
                                                isRequired={true}
                                                onChange={(val) => {
                                                    setSelectedSaleBy(val)
                                                    setValue(
                                                        'sale_by',
                                                        val ? val.value : "",
                                                        { shouldValidate: true }
                                                    );
                                                }}
                                            />     
                                            {errors?.sale_by &&
                                                <InputError
                                                    message={errors.sale_by.message}
                                                />
                                            }
                                        </div>
                                        <div className="col-md-4">
                                            <label htmlFor="sale_type_id" className="col-form-label text-start">Sales Type</label>
                                            <CustomSelect
                                                name="sale_type_id"
                                                options={selectInputOptions?.sales_types}
                                                control={control}
                                                value={selectedSalesType}
                                                isLoading={selectInputOptionsLoading}
                                                isRequired={true}
                                                onChange={(val) => {
                                                    setSelectedSalesType(val)
                                                    setValue(
                                                        'sale_type_id',
                                                        val ? val.value : "",
                                                        { shouldValidate: true }
                                                    );
                                                }}
                                            />     
                                            {errors.sale_type_id &&
                                                <InputError
                                                    message={errors.sale_type_id.message}
                                                />
                                            }
                                        </div>

                                        <div className="col-md-4">
                                            <label htmlFor="client" className="col-form-label text-start">Client</label>                                                
                                            <CustomSelect
                                                name="client"
                                                options={clients}
                                                control={control}
                                                value={selectedClient}
                                                isLoading={clientLoading}
                                                isRequired={true}
                                                onChange={(val) => {
                                                    setSelectedClient(val)
                                                    setValue(
                                                        `client`,
                                                        val ? val.value : "",
                                                        { shouldValidate: true }
                                                    );
                                                }}
                                            />   
                                            {errors.client &&
                                                <InputError
                                                    message={errors.client.message}
                                                />
                                            }
                                        </div>
                                    </div>
                                </div>
                                <div className="col-12 col-md-12">
                                    <div className="row">
                                        <div className="col-md-12">
                                            <label htmlFor="product_nr" className="col-form-label text-start">Product Nr</label>
                                                <CustomSelect
                                                    name={`product_nr`}
                                                    options={products}
                                                    onInputChange={(newValue) => setSearchTerm(newValue)}
                                                    onChange={(e) => handleProductNrChange(e)}
                                                    value={selectedProductNr}
                                                    control={control}
                                                    isLoading={productsLoading}
                                                />
                                                {/* {productFields?.length <= 0 &&
                                                    <InputError
                                                        message='This Is required'
                                                    />
                                                } */}
                                        </div>
                                    </div>
                                </div>                                    
                            </div>                                
                        </div>                            
                    </div>
                    {
                        productFields?.map((field, index) => {                             
                            return (
                                <ProductCard
                                    key={field.id}
                                    index={index}
                                    errors={errors['products'] ? errors['products'] : {}}
                                    cancelProduct={handleCancelProduct}
                                    item={selectedProducts[index]}
                                    register={register}
                                    setValue={setValue}
                                    totalWeightCount={totalWeightCount}
                                    totalSubTotalCount={totalSubTotalCount}
                                    totalStDiaCount={totalStDiaCount}
                                />
                            )
                        })
                    }

                    <PosCreateTotalInfoCard
                        selectInputOptions={selectInputOptions}
                        control={control}
                        setValue={setValue}
                        register={register}
                        data={{
                            totalSubTotal,
                            totalWeight,
                            totalStDia
                        }}
                        setTotalAmountToPaid={setTotalAmountToPaid}
                        
                    />    
                    
                    <PaymentCard handleAddPaymentOption={handleAddPaymentOption}>
                        {/* payment options card */}
                        {fields?.map((field, index) =>
                            <PaymentCardBody
                                key={field.id} 
                                index={index}
                                cancelPaymentOption={()=>cancelPaymentOption(index)}
                                selectInputOptionsLoading={selectInputOptionsLoading}
                                selectInputOptions={selectInputOptions}
                                control={control}
                                register={register}
                                setValue={setValue}
                                errors={errors['payments'] ? errors['payments'] : {}}
                                onPaymentAmountChange={onPaymentAmountChange}
                            />
                        )}

                        {/* Paid Information */}
                        <div className='shadow-lg my-2'>
                            <table className="w-100 table card-table  table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Paid:</td>
                                        <td style={{padding: '5px'}}>
                                            <input
                                                {...register(
                                                    `paid`,
                                                )}
                                                style={{ width: '100%', height: '32px', border: 'none' }}
                                                type="number"
                                                value={totalPayAmount}
                                                readOnly
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cash Back:</td>
                                        <td style={{padding: '5px'}}>
                                            <input
                                                {...register(`return_amount`)
                                                }
                                                style={{ width: '100%', height: '32px', border: totalDueAmount >= 0 && 'none' }}
                                                type="num"
                                                onKeyUp ={(e) => handleReturnAmountChange(e.target.value)}
                                                  
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Due</td>
                                        <td style={{padding: '5px'}}>
                                             <input
                                                {...register(`due`, {
                                                    onChange: ()=> setValue('due', totalDueAmount)
                                                })
                                                }
                                                style={{ width: '100%', height: '32px', border: 'none' }}
                                                type="number"
                                                defaultValue={totalDueAmount}
                                                readOnly
                                            />
                                        </td>
                                    </tr>                                   
                                </tbody>
                            </table>
                        </div>
                    </PaymentCard>  
                    <div className="box-footer mt20 text-end">
                        <button type="submit" className="btn btn-primary btn-lg">Save &amp; Preview</button>                                        
                    </div>                        
                </form>
            </div>
            {/* <!-- end col --> */}
        </div>
    );
};

export default PosCreate;