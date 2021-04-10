import React, { Component } from 'react'

export default class FilterBox extends Component {
    render() {
        return (
            <div className="col-md-4 float-left">
                {/* <h4 className="d-none d-md-block">Search media:</h4> */}
                <div className="input-group mt-2 mt-md-0">
                    <input type="search" className="form-control" />
                    <div className="input-group-append">
                        <button type="button" className="btn btn-primary">
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div className="filter-box mt-2">
                    <div>
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span>Sort By: </span>
                            </div>
                            <div className="form-check">
                                <input className="form-check-input" type="radio" id="name-radio" value="name" checked />
                                <label className="form-check-label" for="name-radio">
                                    Name
                                </label>
                                <input className="form-check-input" type="radio" id="date-radio" value="date" checked />
                                <label className="form-check-label" for="date-radio">
                                    date
                                </label>
                            </div>
                        </div>
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span>File type</span>
                            </div>
                            <select id="file-type-select2" defaultValue="image">
                                <option value="image" icon_name="fas fa-image">image</option>
                            </select>
                        </div>
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span>Format</span>
                            </div>
                            <select id="file-format-select2" defaultValue="image">
                                <option value="jpg">jpg</option>
                                <option value="jpeg">jpeg</option>
                                <option value="png">png</option>
                                <option value="svg">svg</option>
                                <option value="git">gif</option>
                            </select>
                        </div>
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span>Order: </span>
                            </div>
                            <div className="form-check">
                                <input className="form-check-input" type="radio" id="asc-radio" value="name" checked />
                                <label className="form-check-label" for="asc-radio">
                                    ascending
                                </label>
                                <input className="form-check-input" type="radio" id="desc-radio" value="date" checked />
                                <label className="form-check-label" for="desc-radio">
                                    descending
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
