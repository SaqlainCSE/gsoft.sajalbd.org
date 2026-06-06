import React, { useState } from 'react';
import ReactPaginate from 'react-paginate';

const MyPaginate = ({ itemsPerPage, items }) => {
   const [items, paginate] = Paginate(itemsPerPage, items)
}

const Paginate = ({ itemsPerPage, items }) => {
    // Here we use item offsets; we could also use page offsets
    // following the API or data you're working with.
    const [itemOffset, setItemOffset] = useState(0);
    console.log(itemsPerPage, items)

    // Simulate fetching items from another resources.
    // (This could be items from props; or items loaded in a local state
    // from an API endpoint with useEffect and useState)
    const endOffset = itemOffset + itemsPerPage;
    console.log(`Loading items from ${itemOffset} to ${endOffset}`);
    const currentItems = items.slice(itemOffset, endOffset);
    const pageCount = Math.ceil(items.length / itemsPerPage);

    // Invoke when user click to request another page.
    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % items.length;
        console.log(
        `User requested page number ${event.selected}, which is offset ${newOffset}`
        );
        setItemOffset(newOffset);
    };
    return [
        currentItems,
        <ReactPaginate
            breakLabel="..."
            nextLabel={<img src="./img/icon/arrow-right.svg" />}
            nextLinkClassName="page-link"
            nextClassName="page-item ml-2"
            onPageChange={handlePageClick}
            pageRangeDisplayed={5}
            pageCount={pageCount}
            previousLabel={<img src="./img/icon/arrow-left.svg" />}
            previousClassName="page-item mr-2"
            previousLinkClassName="page-link"
            renderOnZeroPageCount={null}

            breakClassName={"break-me"}
            activeClassName={"active"}
            containerClassName={"pagination"}
            pageClassName="page-item"
            pageLinkClassName="page-link"
        />
    ];
};

export default Paginate;