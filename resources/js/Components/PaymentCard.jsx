import React from 'react';

const PaymentCard = ({children, handleAddPaymentOption}) => {
    return (
        <div className="card shadow-sm mb-2 shadow-lg mb-1">
            <div className="card-header d-flex align-items-center justify-content-between">
                <span>Payment Information</span>                   
                <span
                    onClick={handleAddPaymentOption}
                    className="badge badge-success px-3 text-right"
                    style={{ fontSize: '14px' }}
                >
                    Add
                </span>
            </div>
            {children}
              
        </div>
    );
};

export default PaymentCard;