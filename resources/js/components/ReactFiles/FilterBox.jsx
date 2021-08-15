import React, { Component } from 'react';
import { formatOptionWithIcon, formatOptionWithText } from '../../select2'
import {trashMode, resetFiles, changeFilter, deleteFileBulk, restoreFileBulk} from './actions'

class FilterBox extends Component {
    constructor(props) {
        super(props)
        this.trashBtnRef = React.createRef()
        this.fileTypeRef = React.createRef()
        this.extentionRef = React.createRef()
        this.state = {
            searchText: "",
            selectedAction: "1",
            bulkActions: [
                {
                    title: 'Move to trash',
                    icon: 'fas fa-trash',
                    action: deleteFileBulk,
                    enabled: () => true
                },
                {
                    title: 'Restore',
                    icon: 'fas fa-reset',
                    action: restoreFileBulk,
                    enabled: this.restoreCondition
                }
            ]
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

    handleActionSubmit = () => {
        let action = this.state.bulkActions[Number(this.state.selectedAction) - 1].action()
        this.props.dispatch(action)
    }

    restoreCondition = () => this.props.filters.trash

    render() {
        let {searchText, bulkActions, selectedAction} = this.state
        let {selectedFiles, filters} = this.props
        let {orderBy, fileType, filterList} = filters
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
                                    <label className="form-check-label pointer" htmlFor="date-radio">date created</label>
                                    <i className={`fas fa-sort-numeric-${orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                                {filters.trash && 
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="deleted-date-radio" value="deleted_at" onChange={e => this.filter({sortBy: e.target.value})} />
                                    <label className="form-check-label pointer" htmlFor="deleted-date-radio">date deleted</label>
                                    <i className={`fas fa-sort-numeric-${orderBy === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>}
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
                            <select id="file-format-select2" ref={this.extentionRef} defaultValue="all" onChange={e => this.filter({extention: e.target.value})}>
                                <option value="all">all</option>
                                {filterList.fileTypes[fileType].extentions.map((format, i) => (
                                    <option value={format} key={i}>{format}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className={`col-12 mt-2 inline-flex inline-flex-100 ${selectedFiles.length < 1 ? 'd-none' : ''}`}>
                        <p className="float-left mr-2">Bulk Actions <span className="badge badge-pill badge-primary">{selectedFiles.length}</span> :</p>
                        <select className="float-left" onChange={e => this.setState({selectedAction: e.target.value})} value={selectedAction}>
                            {bulkActions.map((action, i) => (
                                <option disabled={! action.enabled()} key={i} value={i + 1}>{action.title}</option>
                            ))}
                        </select>
                        <button type="button" onClick={this.handleActionSubmit} className="btn btn-sm btn-outline-dark">submit</button>
                    </div>
                </div>
            </div>
        );
    }


    // handleChangeFileType = (e) => this.filter({fileType: e.target.value})
    // handleChangeExtention = e => this.filter({extention: e.target.value})

    // componentDidMount = () => {
    //     let options = {templateResult: formatOptionWithText, width: "100%"}
    //     // let fileTypeSelect2 = $(this.fileTypeRef.current)
    //     // let extentionSelect2 = $(this.extentionRef.current)
    //     // fileTypeSelect2.select2(options)
    //     // extentionSelect2.select2(options)
    //     // fileTypeSelect2.on("select2:select", this.handleChangeFileType)
    //     // extentionSelect2.on("select2:select", this.handleChangeExtention)
    // }
}

export default FilterBox;