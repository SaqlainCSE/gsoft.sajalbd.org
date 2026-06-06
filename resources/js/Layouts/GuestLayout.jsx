import React, { useEffect } from "react";

const GuestLayout = ({ children }) => {
    return (
        <div id="appCapsule" className="pt-0">
            {children}
        </div>
    );
};

export default GuestLayout;
