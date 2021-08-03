import React, { Component } from 'react';
import Axios from 'axios';
import Uploader from './Uploader';
import Gallery from './Gallery';
import FilterBox from './FilterBox';

class ReactFiles extends Component {
    constructor(props) {
        super(props)
        this.state = {
            files: [],
            selectedFiles: [],
            loading: false,
            defaultQuery: this.props.searchUrl + '?type=image&order_by=created_at&order=desc'
        }
        this.mediaRef = React.createRef()
    }

    dispatch = async (action) => {
        var iniState = Object.assign({}, this.state);
        switch (action.type) {
            case 'files/add':
                iniState.files = (action.end) ? [...iniState.files, action.file] : [action.file, ...iniState.files]
                break;
            case 'files/addMultiple':
                iniState.files = [...iniState.files, ...action.files]
                break;
            case 'file/delete':
                let {fileUrl} = this.props;
                if (action.softDeleted) {
                    fileUrl += '?force_delete=true'
                }
                await Axios.delete(fileUrl.replace('fileId', action.fileId)).then((res) => {
                    if (res.data.okay) {
                        iniState.files = iniState.files.filter(x => x.id !== action.fileId)
                    }
                })
                break;
            case 'files/toggleSelect':
                iniState.selectedFiles = iniState.selectedFiles.includes(action.fileId)
                ? iniState.selectedFiles.filter(x => x !== action.fileId)
                : [...iniState.selectedFiles, action.fileId];
                break;
            default:
                break;
        }
        this.setState(iniState)
    }

    render() {
        let {uploadUrl, searchUrl, fileUrl, restoreUrl} = this.props
        let {files, selectedFiles, loading, defaultQuery} = this.state;
        return (
            <div>
                <div className="filterbox-uploader-container">
                    <FilterBox />
                    <Uploader uploadUrl={uploadUrl} dispatch={this.dispatch}/>
                </div>
                <Gallery files={files} fileUrl={fileUrl} selectedFiles={selectedFiles}
                query={defaultQuery} loading={loading} dispatch={this.dispatch} ref={this.mediaRef}/>
            </div>
        );
    }
}

export default ReactFiles;