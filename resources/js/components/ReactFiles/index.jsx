import React, { Component } from 'react';
import Axios from 'axios';
import Uploader from './Uploader';
import Gallery from './Gallery';
import FilterBox from './FilterBox';
import {selectAll} from './actions'

class ReactFiles extends Component {
    constructor(props) {
        super(props)
        this.state = {
            files: [],
            selectedFiles: [],
            loading: false,
            defaultQuery: this.props.searchUrl + '?type=image&order_by=created_at&order=desc',
            filters: {
                trash: false,
                orderBy: 'desc',
                sortBy: 'created_at',
                fileType: 'image',
                extention: "all",
                selectAll: false,
                filterList: {
                    fileTypes: {
                        image: {extentions: ["jpeg", "jpg", "png", "svg", "gif"], icon: "fas fa-image"},
                        video: {extentions:["mp4", "mov", "wmv", "flv", "avi", "mkv"], icon: "fas fa-video"},
                        audio: {extentions:["mp3", "pcm", "wav", "aiff", "aac", "ogg", "wma", "falc"], icon: "fas fa-microphone"}
                    }
                }
            }
        }
        this.mediaRef = React.createRef()
    }

    dispatch = async (action) => {
        var iniState = Object.assign({}, this.state);
        let {fileUrl, restoreUrl} = this.props;
        switch (action.type) {
            case 'filter/change':
                Object.assign(iniState.filters, action.payload)
                break
            case 'files/reset':
                iniState.files = []
                iniState.selectedFiles = []
                iniState.filters.selectAll = false
                iniState.defaultQuery = action.query
                this.mediaRef.current.reset()
                break
            case 'files/add':
                iniState.files = (action.end) ? [...iniState.files, action.file] : [action.file, ...iniState.files]
                break
            case 'files/addMultiple':
                iniState.files = [...iniState.files, ...action.files]
                break
            case 'file/delete':
                if (action.softDeleted) {
                    fileUrl += '?force_delete=true'
                }
                await Axios.delete(fileUrl.replace('fileId', action.fileId)).then((res) => { // await
                    if (res.data.okay) {
                        iniState.files = iniState.files.filter(x => x.id !== action.fileId)
                    }
                })
                break
            case 'file/restore':
                await Axios.patch(restoreUrl.replace('fileId', action.fileId)).then(res => {
                    if (res.data.okay && iniState.filters.trash) {
                        iniState.files = iniState.files.filter(x => x.id !== action.fileId)
                    }
                })
                break
            case 'file/bulkRestore':
                let id_requested = iniState.selectedFiles.join(',');
                let restorePath = restoreUrl.replace('fileId', id_requested);
                if (iniState.filters.trash) {
                    await Axios.patch(restorePath).then(res => {
                        iniState.files = iniState.files.filter(x => ! id_requested.includes(x.id))
                        iniState.selectedFiles = []
                        iniState.filters.selectAll = false
                    })
                }
                break
            case 'file/bulkDelete':
                let id_request = iniState.selectedFiles.join(',');
                let path = fileUrl.replace('fileId', id_request);
                path += iniState.filters.trash ? '?force_delete=true' : ''
                await Axios.delete(path).then(res => {
                    iniState.files = iniState.files.filter(x => ! id_request.includes(x.id))
                    iniState.selectedFiles = []
                    iniState.filters.selectAll = false
                })
                break
            case 'files/toggleSelect':
                iniState.selectedFiles = iniState.selectedFiles.includes(action.fileId)
                ? iniState.selectedFiles.filter(x => x !== action.fileId)
                : [...iniState.selectedFiles, action.fileId];
                break
            case 'filter/toggleTrash':
                iniState.filters.trash = ! iniState.filters.trash
                break
            case 'filter/toggleSelectAll':
                iniState.filters.selectAll = ! iniState.filters.selectAll
                iniState.selectedFiles = iniState.filters.selectAll ? iniState.files.map(file => file.id) : []
                break
            default:
                break
        }
        this.setState(iniState)
        return
    }

    render() {
        let {uploadUrl, searchUrl, fileUrl, restoreUrl, editFormUrl} = this.props
        let {files, selectedFiles, loading, defaultQuery, filters} = this.state;
        return (
            <div>
                <div className="filterbox-uploader-container">
                    <FilterBox filters={filters} selectedFiles={selectedFiles} searchUrl={searchUrl} dispatch={this.dispatch}/>
                    <Uploader uploadUrl={uploadUrl} dispatch={this.dispatch}/>
                </div>
                <div className="col-12 p-2 remove-sm-padding float-left">
                    <button className="btn btn-sm btn-light float-right" onClick={() => this.dispatch(selectAll())}>{filters.selectAll ? 'un' : ''}select all</button>
                </div>
                <Gallery editFormUrl={editFormUrl} files={files} fileUrl={fileUrl} selectedFiles={selectedFiles} query={defaultQuery} loading={loading} dispatch={this.dispatch} ref={this.mediaRef}/>
            </div>
        );
    }
}

export default ReactFiles;