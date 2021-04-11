import React, { Component } from 'react'
import { formatOptionWithIcon, formatOptionWithText } from '../../select2'

export default class FilterBox extends Component {
    constructor(props) {
        super(props)
        this.state = {
            searchValue: "",
            filters: {
                sort_by: "name",
                file_type: "image",
                format: "all",
                order: "asc",
                trash: false,
                available_formats: {
                    image: ["jpeg", "jpg", "png", "svg", "gif"],
                    video: ["mp4", "mov", "wmv", "flv", "avi", "mkv"],
                    audio: ["mp3", "pcm", "wav", "aiff", "aac", "ogg", "wma", "falc"]
                }
            }
        }
    }

    changeFilter = (filter, e) => {
        e.persist()
        this.setState(prevState => ({
            filters: {
                ...prevState.filters,
                [filter]: e.target.value
            }
        })
        )
    }

    componentDidMount() {
        const renderFileTypeWithSelect2 = () => {
            $("#file-type-select2").select2({
                templateResult: formatOptionWithIcon,
                width: "100%"    
            })
            $("#file-format-select2").val("all").change()
        }
        const renderFileFormatWithSelect2 = () => {
            $("#file-format-select2").select2({
                templateResult: formatOptionWithText,
                width: "100%"    
            })
        }
        const setFileType = () => {
            this.setState(prevState => ({
                filters: {
                    ...prevState.filters,
                    file_type: $("#file-type-select2").val(),
                    format: "all"
                }
            }))
            renderFileTypeWithSelect2()
            renderFileFormatWithSelect2()
        }
        const setFileFormat = () => {
            this.setState(prevState => ({
                filters: {
                    ...prevState.filters,
                    format: $("#file-format-select2").val()
                }
            }))
            renderFileFormatWithSelect2()
        }

        renderFileTypeWithSelect2()
        renderFileFormatWithSelect2()
        $('.select2-search__field').css('width', '100%')
        $("#file-type-select2").on("select2:select", function () {
            setFileType()
        })
        $("#file-format-select2").on("select2:select", function () {
            setFileFormat()
        })
    }

    filter = (e) => {
        let { searchValue } = this.state
        if (e.type === "click" || e.keyCode === 13) {
            // here we will send the req
        }
    }

    render() {
        let { filters, searchValue } = this.state 

        return (
            <div className="col-lg-4 float-left remove-sm-padding">
                <h4 className="d-none d-lg-block">Search media:</h4>
                <div className="input-group mt-2 mt-lg-0">
                    <input type="search" className="form-control" value={searchValue} onChange={(e) => this.setState({searchValue: e.target.value})} onKeyUp={this.filter.bind(this)} />
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
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="name-radio" value="name" onChange={this.changeFilter.bind(this, "sort_by")} defaultChecked />
                                    <label className="form-check-label pointer" htmlFor="name-radio">Name</label>
                                    <i className={`fas fa-sort-alpha-${filters.order === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="date-radio" value="date" onChange={this.changeFilter.bind(this, "sort_by")} />
                                    <label className="form-check-label pointer" htmlFor="date-radio">date</label>
                                    <i className={`fas fa-sort-amount-${filters.order === "asc" ? "down tada" : "up-alt wobble"} ml-2 animated`}></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span>Order: </span>
                            <div className="form-check">
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="asc-radio" value="asc" onChange={this.changeFilter.bind(this, "order")} defaultChecked />
                                    <label className="form-check-label pointer" htmlFor="asc-radio">ascending</label>
                                </div>
                                <div>
                                    <input className="pointer form-check-input" type="radio" name="order-radios" id="desc-radio" value="desc" onChange={this.changeFilter.bind(this, "order")} />
                                    <label className="form-check-label pointer" htmlFor="desc-radio">descending</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-12 mt-2 inline-flex inline-flex-100">
                        <div className="filter-option">
                            <span className="mb-1 mb-md-0">File type: </span>
                            <select id="file-type-select2" defaultValue="image">
                                <option value="image" icon_name="fas fa-image">image</option>
                                <option value="video" icon_name="fas fa-video">video</option>
                                <option value="audio" icon_name="fas fa-microphone">audio</option>
                            </select>
                        </div>
                        <div className="filter-option format-select2">
                            <span className="mb-1 mb-md-0">Format: </span>
                            <select id="file-format-select2" defaultValue="all">
                                <option value="all">all</option>
                                {filters.available_formats[filters.file_type].map((format, i) => (
                                    <option value={format} key={i}>{format}</option>
                                ))
                                }
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
