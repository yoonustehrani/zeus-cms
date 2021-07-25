import React, { Component } from 'react'
import { formatOptionWithIcon, formatOptionWithText } from '../../select2'
import Axios from 'axios'

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
            },
        }
        this.trashBtnRef = React.createRef()
    }

    filter = (e) => {
        let { searchValue, filters } = this.state, q
        let { searchUrl, setNewResults, setLoading, setScroller } = this.props
        if (e.type === "click" || e.type === "change" || e.type === "select2:select" || e.keyCode === 13) {
            let search_query = `${searchUrl}?type=${filters.file_type}${filters.format !== "all" ? `&ext=${filters.format}` : ""}&order_by=${filters.sort_by}&order=${filters.order}${filters.trash ? "&trash=true" : ""}${searchValue.replace(/\s/g, " ").trim().length >= 3 ? `&q=${searchValue.replace(/\s/g, " ").trim().replace(/\s/g, "+")}` : ""}`
            setLoading(true)
            Axios.get(`${search_query}&page=1`).then(res => {
                let { data, current_page, last_page } = res.data
                setScroller({
                    hasMore: current_page !== last_page,
                    current_page: current_page,
                    data: data,
                    loading: false
                })
                setNewResults(data, search_query)
                setLoading(false)
            })
        }
    }

    changeFilter = (filter, e) => {
        e.persist()
        filter === "trash" ? this.trashBtnRef.current.classList.toggle("btn-dark") : null
        this.setState(prevState => ({
            filters: {
                ...prevState.filters,
                [filter]: filter === "trash" ? !prevState.filters.trash : e.target.value
            }
        }), () => {
            this.filter(e)
        })
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
        const setFileType = (e) => {
            this.setState(prevState => ({
                filters: {
                    ...prevState.filters,
                    file_type: $("#file-type-select2").val(),
                    format: "all"
                }
            }), () => {
                this.filter(e)
            })
            renderFileTypeWithSelect2()
            renderFileFormatWithSelect2()
            
        }
        const setFileFormat = (e) => {
            this.setState(prevState => ({
                filters: {
                    ...prevState.filters,
                    format: $("#file-format-select2").val()
                }
            }), () => {
                this.filter(e)
            })
            renderFileFormatWithSelect2()
        }
        $('.select2-search__field').css('width', '100%')
        $("#file-type-select2").on("select2:select", function (e) {
            setFileType(e)
        })
        $("#file-format-select2").on("select2:select", function (e) {
            setFileFormat(e)
        })
        // the next 2 lines are for the initial render
        renderFileTypeWithSelect2()
        renderFileFormatWithSelect2()
    }

    render() {
        let { filters, searchValue } = this.state 

        return (
            <div className="col-lg-4 float-left remove-sm-padding">
                {/* <h4 className="d-none d-lg-block">Search media:</h4> */}
                <div className="input-group mt-2 mt-lg-0">
                    <div className="input-group-prepend">
                        <button type="button" className="btn btn-light" ref={this.trashBtnRef} onClick={this.changeFilter.bind(this, "trash")}>
                            <i className="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <input type="search" className="form-control" value={searchValue} placeholder="3 characters or more (name or format)" onChange={(e) => this.setState({searchValue: e.target.value})} onKeyUp={this.filter.bind(this)} />
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
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="date-radio" value="created_at" onChange={this.changeFilter.bind(this, "sort_by")} />
                                    <label className="form-check-label pointer" htmlFor="date-radio">date</label>
                                    <i className={`fas fa-sort-numeric-${filters.order === "asc" ? "down tada" : "up wobble"} ml-2 animated`}></i>
                                </div>
                                {/* <div>
                                    <input className="pointer form-check-input" type="radio" name="sort-by-radios" id="ext-radio" value="ext" onChange={this.changeFilter.bind(this, "sort_by")} />
                                    <label className="form-check-label pointer" htmlFor="ext-radio">Format</label>
                                    <i className={`fas fa-sort-numeric-${filters.order === "asc" ? "down-alt tada" : "up-alt wobble"} ml-2 animated`}></i>
                                </div> */}
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
