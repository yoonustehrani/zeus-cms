import Axios from 'axios';
import React, { Component } from 'react';
import {trashMode, resetFiles, changeFilter} from './actions'

class FilterBox extends Component {
    constructor(props) {
        super(props)
        this.trashBtnRef = React.createRef()
        this.state = {
            searchText: ""
        }
    }

    prepareQuery = () => {
        let searchText = this.state.searchText.trim().replace(/\s{2,}/g, " ").replace(/\s/g, "+")
        let {searchUrl, filters} = this.props
        let {file_type, orderBy, sortBy, trash} = filters
        let query = `${searchUrl}?type=${file_type}&order_by=${sortBy}&order=${orderBy}`
        query += searchText.length > 2 ? `&q=${searchText}` : ''
        query += trash ? '&trash=true' : ''
        return query
    }

    reset = () => {
        this.props.dispatch(resetFiles(this.prepareQuery()))
    }

    filter = (payload = null) => {
        this.props.dispatch(changeFilter(payload))
        this.reset()
    }

    handleTrashToggle = () => {
        let { dispatch } = this.props
        this.trashBtnRef.current.classList.toggle("btn-dark")
        dispatch(trashMode())
        this.reset()
    }


    render() {
        let {searchText} = this.state
        let {filters, dispatch} = this.props
        return (
            <div className="col-lg-4 float-left remove-sm-padding">
                <div className="input-group mt-2 mt-lg-0">
                    <div className="input-group-prepend">
                        <button type="button" className="btn btn-light" ref={this.trashBtnRef} onClick={this.handleTrashToggle} >
                            <i className="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <input type="search" className="form-control" value={searchText} placeholder="3 characters or more (name or format)" 
                    onChange={(e) => this.setState({searchText: e.target.value})} 
                    onKeyUp={(e) => {
                        if (e.key == 'Enter') {
                            this.filter()
                        }
                    }}
                    />
                    <div className="input-group-append">
                        <button type="button" className="btn btn-primary" onClick={this.filter.bind(this)}>
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div className="filter-box mt-2 pt-2 pb-2">
                <div className="col-12 inline-flex">
                        <div>
                            <span>Sort By:</span>
                            <div className="form-check">
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="name-radio" value="name" onChange={(e) => this.filter({sortBy: e.target.value})} />
                                    <label className="form-check-label pointer" htmlFor="name-radio">Name</label>
                                    <i className={`fas fa-sort-alpha-${filters.orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="date-radio" value="created_at" onChange={(e) => this.filter({sortBy: e.target.value})} defaultChecked/>
                                    <label className="form-check-label pointer" htmlFor="date-radio">date</label>
                                    <i className={`fas fa-sort-numeric-${filters.orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span>Order: </span>
                            <div className="form-check">
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="asc-radio" value="asc" onChange={(e) => this.filter({orderBy: e.target.value})} />
                                    <label className="form-check-label pointer" htmlFor="asc-radio">ascending</label>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="desc-radio" value="desc" onChange={(e) => this.filter({orderBy: e.target.value})} defaultChecked/>
                                    <label className="form-check-label pointer" htmlFor="desc-radio">descending</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default FilterBox;