import Axios from 'axios';
import React, { Component } from 'react';
import {trashMode} from './actions'

class FilterBox extends Component {
    constructor(props) {
        super(props)
        this.trashBtnRef = React.createRef()
        this.state = {
            searchText: ""
        }
    }

    prepareQuery = () => {
        let {searchUrl, filters} = this.props
        let {file_type, orderBy, sortBy, trash} = filters;
        let query = `${searchUrl}?type=${file_type}&order_by=${sortBy}&order=${orderBy}`
        query += trash ? '&trash=true' : ''
    }

    filter = () => {

    }

    handleTrashToggle = () => {
        let { searchUrl, dispatch } = this.props
        this.trashBtnRef.current.classList.toggle("btn-dark")
        dispatch(trashMode())
        
        // dispatch()
    }
    render() {
        let {searchText} = this.state
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
                    // onKeyUp={this.filter.bind(this)} 
                    />
                    <div className="input-group-append">
                        <button type="button" className="btn btn-primary"
                        // onClick={this.filter.bind(this)}
                        >
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        );
    }
}

export default FilterBox;