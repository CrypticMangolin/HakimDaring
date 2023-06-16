import { useState, useEffect } from 'react'
import { Button, Col, Container, Form, InputGroup, Modal, Row } from 'react-bootstrap'
import Header from '../Header'
import { useNavigate, useParams } from 'react-router-dom';
import RequestAmbilInformasiSoalPrivate from '../../core/Soal/RequestAmbilInformasiSoalPrivate';
import RequestEditSoal from '../../core/Soal/RequestEditSoal';
import BerhasilAmbilInformasiSoalPrivate from '../../core/Responses/ResponseBerhasil/Soal/BerhasilAmbilInformasiSoalPrivate';
import ModelInputModal from '../../model/ModelInputModal';
import TidakMemilikiHak from '../../core/Responses/ResponseGagal/TidakMemilikiHak';
import KesalahanInputData from '../../core/Responses/ResponseGagal/KesalahanInputData';
import KesalahanInternalServer from '../../core/Responses/ResponseGagal/KesalahanInternalServer';
import Testcase from '../../core/Soal/Data/Testcase';
import EditSoal from '../../core/Soal/Data/EditSoal';
import BatasanSoal from '../../core/Soal/Data/BatasanSoal';
import BerhasilEditSoal from '../../core/Responses/ResponseBerhasil/Soal/BerhasilUbahSoal';

function HalamanUbahSoal() {

  const parameterURL = useParams()
  const navigate = useNavigate()

  const requestAmbilInformasiSoalPrivate : RequestAmbilInformasiSoalPrivate = new RequestAmbilInformasiSoalPrivate()
  const requestEditSoal : RequestEditSoal = new RequestEditSoal()

  let [dataSoal, setDataSoal] = useState<BerhasilAmbilInformasiSoalPrivate|null>(null)
  let [editSoal, setEditSoal] = useState<EditSoal>(
    {
      id_soal : "",
      judul : "",
      soal : "",
      batasan : {
        waktu_per_testcase : 1,
        waktu_total : 10,
        memori : 128000
      } as BatasanSoal,
      daftar_testcase : []
    } as EditSoal
  )
  
  const [popupInputString, setPopupInputString] = useState<boolean>(false)
  const [dataModalString, setDataModalString] = useState<ModelInputModal<string>>({
    testcase : null,
    namaAttribute : "",
    nilai : ""
  });

  function ambilDataSoalDanTestcase () {
    if (parameterURL.id_soal === undefined) {
      navigate("/")
    }

    let idSoal = parameterURL.id_soal!
    requestAmbilInformasiSoalPrivate.execute(idSoal, (hasil : any) => {
      if (hasil instanceof BerhasilAmbilInformasiSoalPrivate) {
        
        (window as any).editor_soal.setData(hasil.isi_soal)
        
        let daftarTestcase : Testcase[] = [];
        for (let i = 0; i < hasil.daftar_testcase.length; i++) {
          let testcase = hasil.daftar_testcase[i]
          daftarTestcase.push({
            testcase : testcase.testcase,
            jawaban : testcase.jawaban,
            publik : testcase.publik
          })
        }

        setDataSoal(hasil)
        setEditSoal({
          id_soal : hasil.id_soal,
          judul : hasil.judul,
          soal : hasil.isi_soal,
          batasan : {
            waktu_per_testcase : hasil.batasan.waktu_per_testcase,
            waktu_total : hasil.batasan.waktu_total,
            memori : hasil.batasan.memori,
          } as BatasanSoal,
          daftar_testcase : daftarTestcase
        } as EditSoal)
      }
      else if (hasil instanceof TidakMemilikiHak) {
        navigate("/")
      }
      else if (hasil instanceof KesalahanInputData) {

      }
      else if (hasil instanceof KesalahanInternalServer) {
        
      }
    })
  }

  useEffect(() => {
    function loadScriptCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor") == null) {
          const script = document.createElement('script');
          script.src = "/ckeditor5-37.1.0/build/ckeditor.js";
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
        }
      });
    }
    function loadScriptCustomCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor-custom-build") == null) {
          const script = document.createElement('script');
          script.innerHTML = `
            let ckEditor = null
            
            ClassicEditor.create( '', {
                licenseKey: '',
            })
            .then( editor => {
                window.editor_soal = editor;
                window.editor_soal.setData("")
                editor.model.document.on('change:data', () => {
                  window.perubahanCKEditor(editor.getData())
                })
                document.getElementById("editor").appendChild(editor.ui.element)
                window.ambilDataSoalDanTestcase()
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: n96xuuc5ag4v-nk96buq2xi5g' );
                console.error( error );
            })`;
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor-custom-build"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
          document.getElementById("editor")?.appendChild((window as any).editor_soal.ui.element)
          ambilDataSoalDanTestcase()
        }
      });
    }

    async function loadCKEditor() {
      await loadScriptCKEditor()
      await loadScriptCustomCKEditor()

    }
    
    (window as any).ambilDataSoalDanTestcase = ambilDataSoalDanTestcase
    return () => {
      loadCKEditor()
    }
  }, []);

  const hapusTestcase = (testcase : Testcase) => {
    setEditSoal({...editSoal, daftar_testcase : editSoal.daftar_testcase.filter(t => t !== testcase)})
  }

  const tambahTestcase = (testcase : Testcase) => {
    setEditSoal({...editSoal, daftar_testcase : [...editSoal.daftar_testcase, testcase]})
  }

  const tutupPopupModalUntukTestcase = () => {
    setPopupInputString(false)
    setDataModalString({
      testcase : null,
      namaAttribute : "",
      nilai : ""
    })
  }

  const simpanInputString = () => {
    if (dataModalString != null) {
      (dataModalString.testcase as any)[dataModalString.namaAttribute] = dataModalString.nilai
    }
    tutupPopupModalUntukTestcase()
  }

  function perubahanCKEditor(soal : string) {
    setEditSoal({...editSoal, soal : soal})
  }
  (window as any).perubahanCKEditor = perubahanCKEditor

  function simpanSoal() {

    if (editSoal.id_soal != "") {
      requestEditSoal.execute(editSoal, (hasil : any) => {
          if (hasil instanceof BerhasilEditSoal) {

          } 
          else if (hasil instanceof TidakMemilikiHak) {
  
          }
          else if (hasil instanceof KesalahanInputData) {
  
          }
          else if (hasil instanceof KesalahanInternalServer) {
  
          }
        }
      )
    }

    ambilDataSoalDanTestcase()
  }


  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Row className='m-0 p-0'>
          <Col sm={12} md={8} lg={8} xl={8} className="d-flex flex-column m-0 p-2">
            <Row className='m-0 p-0 d-flex flex-column'>
              <Col className='m-0 p-0'>
                <Row className='m-0 mx-5 mb-4 p-0 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Judul Soal</p>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='text' placeholder="Judul" className='m-2 py-1 text-center' value={editSoal.judul} onChange={(e) => {
                      setEditSoal({...editSoal, judul : e.target.value})
                    }}/>
                  </InputGroup>
                </Row>
              </Col>
              <Col className='m-0 p-0'>
                <Row className='m-0 p-0 pb-4 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Soal</p>
                  <div id='editor' className="editor">
                  </div>
                </Row>
              </Col>
            </Row>
          </Col>
          <Col sm={12} md={4} lg={4} xl={4} className="d-flex flex-column m-0 p-2">
            <Row className='m-0 p-0'>
              <p className='m-0 p-0 fs-4 fw-bold text-center'>Buat Soal</p>
              <Button variant='dark' className='m-2 mb-4' onClick={simpanSoal}>
                Tekan Untuk Menyimpan Perubahan
              </Button>
              <p className='m-0 p-0 py-2 fs-6 text-start'>*Perubahan pada batasan soal atau testcase akan membaut versi soal meningkat yang akan menyebabkan jumlah submit dan submit berhasil kembali menjadi 0</p>

              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Status</p>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Status</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataSoal != null ? dataSoal.status : ""}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Jumlah Submit</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataSoal != null ? dataSoal.jumlah_submit : ""}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Submit Berhasil</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataSoal != null ? dataSoal.jumlah_berhasil : ""}</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 px-2 d-flex flex-row justify-content-center'>
                <Col xs={4}>
                  <p className='fs-6'>Persentase Keberhasilan</p>
                </Col>
                <Col xs={8}>
                  <p className='fs-6'>: {dataSoal != null && dataSoal.jumlah_submit > 0 ? dataSoal.jumlah_berhasil / dataSoal.jumlah_submit : 0}%</p>
                </Col>
              </Col>

              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Batasan Sumber Daya</p>
              <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Waktu per Testcase" className='m-2 py-1 text-center fs-6' value={editSoal.batasan.waktu_per_testcase} onChange={(e) => {
                      setEditSoal({...editSoal, batasan : {...editSoal.batasan, waktu_per_testcase : Number(e.target.value)}})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>sekon</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Waktu Semua Testcase" className='m-2 py-1 text-center fs-6' value={editSoal.batasan.waktu_total} onChange={(e) => {
                      setEditSoal({...editSoal, batasan : {...editSoal.batasan, waktu_total : Number(e.target.value)}})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>sekon</p>
                </Col>
              </Col>
              <Col xs={12} className='m-0 p-0 pb-4 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Memori" className='m-2 py-1 text-center fs-6' value={editSoal.batasan.memori} onChange={(e) => {
                      setEditSoal({...editSoal, batasan : {...editSoal.batasan, memori : Number(e.target.value)}})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>KB</p>
                </Col>
              </Col>
              <p className='m-0 p-0 pb-2 fs-4 fw-bold text-center'>Testcase</p>
              <p className='m-0 p-0 pb-2 fs-6 text-start'>Total Testcase: {editSoal.daftar_testcase.length}</p>
              <Row className='m-0 p-0'>
                {
                  editSoal.daftar_testcase.map((testcase : Testcase, index : number) =>{
                    return (
                      <Col className='m-0 p-0' xs={12} key={"daftarTestcase: " + index}>
                        <Col xs={12} className='m-1 p-0 d-flex flex-row'>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0'
                              onClick={() => {
                                setDataModalString({
                                  "testcase" : testcase,
                                  namaAttribute : "testcase",
                                  nilai : testcase.testcase
                                })

                                setPopupInputString(true)
                              }}
                            >
                              Atur Testcase
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' 
                              onClick={() => {
                                setDataModalString({
                                  "testcase" : testcase,
                                  namaAttribute : "jawaban",
                                  nilai : testcase.jawaban
                                })

                                setPopupInputString(true)
                              }}
                            >
                              Atur Jawaban
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' onClick={
                              () => {
                                testcase.publik = !testcase.publik
                                if (editSoal.daftar_testcase.filter((element) => element.publik).length > 5) {
                                  testcase.publik = false
                                }
                                setEditSoal({...editSoal, daftar_testcase : [...editSoal.daftar_testcase]})
                              }
                            }>
                              {testcase.publik ? "Publik" : "Private"}
                            </Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' onClick={() => {
                               hapusTestcase(testcase)
                            }}>
                              Hapus
                            </Button>
                          </Col>
                        </Col>
                      </Col>
                    )
                  })
                }
                
                <Modal show={popupInputString} onHide={tutupPopupModalUntukTestcase}>
                  <Modal.Header closeButton>
                    <Modal.Title>{dataModalString.namaAttribute}</Modal.Title>
                  </Modal.Header>
                  <InputGroup>
                    <Form.Control 
                      type='text'
                      as="textarea"
                      placeholder={"Tuliskan " + dataModalString.namaAttribute} 
                      onChange={(e) => {
                        setDataModalString({...dataModalString, nilai : e.target.value})
                      }}
                      value={dataModalString.nilai}
                      className='mx-2 p-2'
                    />
                  </InputGroup>
                  <Modal.Footer>
                    <Button variant="light" className='border border-dark' onClick={tutupPopupModalUntukTestcase}>
                      Batalkan
                    </Button>
                    <Button variant="dark" onClick={simpanInputString}>
                      Simpan
                    </Button>
                  </Modal.Footer>
                </Modal>
              </Row>
              <Button variant='dark' onClick={() => {
                if (editSoal.daftar_testcase.length < 20) {
                  tambahTestcase({
                    testcase : "",
                    jawaban : "",
                    publik : false
                  })
                }
              }}>
                Tambah Testcase
              </Button>
            </Row>
          </Col>
        </Row>
      </Container>
    </>
  )

}

export default HalamanUbahSoal