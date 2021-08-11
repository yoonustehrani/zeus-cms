import React, { Component } from 'react';
import { formatOptionWithIcon, formatOptionWithText } from '../../select2'
import {trashMode, resetFiles, changeFilter} from './actions'

class FilterBox extends Component {
    constructor(props) {
        super(props)
        this.trashBtnRef = React.createRef()
        this.fileTypeRef = React.createRef()
        this.state = {
            searchText: ""
        }
    }
    
    prepareQuery = () => {
        let searchText = this.state.searchText.trim().replace(/\s{2,}/g, " ").replace(/\s/g, "+")
        let {searchUrl, filters} = this.props
        let {fileType, orderBy, sortBy, trash, extention} = filters
        let query = `${searchUrl}?type=${fileType}&order_by=${sortBy}&order=${orderBy}`
        query += searchText.length > 2 ? `&q=${searchText}` : ''
        query += trash ? '&trash=true' : ''
        query += extention !== "all" ? `&ext=${extention}` : ''
        return query
    }

    resetFilesState = () => this.props.dispatch(resetFiles(this.prepareQuery()))

    filter = (payload) => {
        this.props.dispatch(changeFilter(payload))
        this.resetFilesState()
    }

    handleTrashToggle = () => {
        this.trashBtnRef.current.classList.toggle("btn-dark")
        this.props.dispatch(trashMode())
        this.resetFilesState()
    }

    handleChange = () => {
        console.log('hey select2 has changed');
    }

    componentDidMount = () => {
        let fileTypeSelect2 = $(this.fileTypeRef.current)
        fileTypeSelect2.select2()
        fileTypeSelect2.on("select2:select", this.handleChange)
    }

    render() {
        let {searchText} = this.state
        let {orderBy, fileType, filterList} = this.props.filters
        return (
            <div className="col-lg-4 float-left remove-sm-padding">
                <div className="input-group mt-2 mt-lg-0">
                    <div className="input-group-prepend">
                        <button type="button" className="btn btn-light" ref={this.trashBtnRef} onClick={this.handleTrashToggle} >
                            <i className="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <input type="search" className="form-control" value={searchText}
                    placeholder="3 characters or more (name or format)" 
                    onChange={(e) => this.setState({searchText: e.target.value})} 
                    onKeyUp={(e) => (e.key == 'Enter') ? this.filter() : null}
                    />
                    <div className="input-group-append">
                        <button type="button" className="btn btn-primary" disabled={searchText.length < 3} onClick={this.reset}>
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
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="name-radio" value="name" onChange={e => this.filter({sortBy: e.target.value})} />
                                    <label className="form-check-label pointer" htmlFor="name-radio">Name</label>
                                    <i className={`fas fa-sort-alpha-${orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="date-radio" value="created_at" onChange={e => this.filter({sortBy: e.target.value})} defaultChecked/>
                                    <label className="form-check-label pointer" htmlFor="date-radio">date</label>
                                    <i className={`fas fa-sort-numeric-${orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span>Order: </span>
                            <div className="form-check">
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="asc-radio" value="asc" onChange={e => this.filter({orderBy: e.target.value})} />
                                    <label className="form-check-label pointer" htmlFor="asc-radio">ascending</label>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="desc-radio" value="desc" onChange={e => this.filter({orderBy: e.target.value})} defaultChecked/>
                                    <label className="form-check-label pointer" htmlFor="desc-radio">descending</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-12 mt-2 inline-flex inline-flex-100">
                        <div className="filter-option">
                            <span className="mb-1 mb-md-0">File type: </span>
                            <select id="file-type-select2" ref={this.fileTypeRef} defaultValue="image" onChange={e => this.filter({fileType: e.target.value})}>
                                {Object.keys(filterList.fileTypes).map((type, i) => (
                                    <option value={type} key={i} icon_name={filterList.fileTypes[type].icon}>{type}</option>
                                ))}
                            </select>
                        </div>
                        <div className="filter-option format-select2">
                            <span className="mb-1 mb-md-0">Format: </span>
                            <select id="file-format-select2" defaultValue="all" onChange={e => this.filter({extention: e.target.value})}>
                                <option value="all">all</option>
                                {filterList.fileTypes[fileType].extentions.map((format, i) => (
                                    <option value={format} key={i}>{format}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default FilterBox;