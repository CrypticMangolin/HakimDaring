import { useState, useEffect } from 'react'
import { Button, Col, Container, Form, InputGroup, Modal, Row } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom';
import Header from '../Header'
import RequestBuatSoal from '../../core/Soal/RequestBuatSoal';
import Testcase from '../../core/Soal/Data/Testcase';
import ModelInputModal from '../../model/ModelInputModal';
import BuatSoal from '../../core/Soal/Data/BuatSoal';
import BatasanSoal from '../../core/Soal/Data/BatasanSoal';
import BerhasilBuatSoal from '../../core/Responses/ResponseBerhasil/Soal/BerhasilBuatSoal';
import TidakMemilikiHak from '../../core/Responses/ResponseGagal/TidakMemilikiHak';
import KesalahanInputData from '../../core/Responses/ResponseGagal/KesalahanInputData';
import KesalahanInternalServer from '../../core/Responses/ResponseGagal/KesalahanInternalServer';

function HalamanBuatSoal() {

  const navigate = useNavigate()

  const requestBuatSoal : RequestBuatSoal = new RequestBuatSoal()
  
  const [popupInputString, setPopupInputString] = useState<boolean>(false)
  const [dataModalString, setDataModalString] = useState<ModelInputModal<string>>({
    testcase : null,
    namaAttribute : "",
    nilai : ""
  });

  const [dataSoal, setDataSoal] = useState<BuatSoal>({
    judul : "",
    soal : "",
    batasan : {
      waktu_per_testcase : 1,
      waktu_total : 10,
      memori : 128000
    } as BatasanSoal,
    daftar_testcase : []
  } as BuatSoal)

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
                window.editor_soal = editor
                window.editor_soal.setData("")
                editor.model.document.on('change:data', () => {
                  window.perubahanCKEditor(editor.getData())
                })
                document.getElementById("editor").appendChild(editor.ui.element)
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
        }
      });
    }

    async function loadCKEditor() {
      await loadScriptCKEditor()
      await loadScriptCustomCKEditor()
    }

    return () => {
      loadCKEditor()
    };

  }, []);

  const hapusTestcase = (testcase : Testcase) => {
    setDataSoal({...dataSoal, daftar_testcase : dataSoal.daftar_testcase.filter(t => t !== testcase)})
  }

  const tambahTestcase = (testcase : Testcase) => {
    setDataSoal({...dataSoal, daftar_testcase : [...dataSoal.daftar_testcase, testcase]})
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
    setDataSoal({...dataSoal, soal : soal})
  }
  (window as any).perubahanCKEditor = perubahanCKEditor

  const pindahHalamanEditSoal = (idSoal : string) => {
    navigate("/edit-soal/"+idSoal)
  }

  function simpanSoal() {
    requestBuatSoal.execute(dataSoal, (hasil : any) => {
        
        if (hasil instanceof BerhasilBuatSoal) {
          pindahHalamanEditSoal(hasil.idSoal)
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
                    <Form.Control type='text' placeholder="Judul" className='m-2 py-1 text-center' value={dataSoal.judul} onChange={(e) => {
                      setDataSoal({...dataSoal, judul : e.target.value})
                    }}/>
                  </InputGroup>
                </Row>
              </Col>
              <Col className='m-0 p-0'>
                <Row className='m-0 p-0 pb-4 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Soal</p>
                  <div id="editor">
                  </div>
                </Row>
              </Col>
            </Row>
          </Col>
          <Col sm={12} md={4} lg={4} xl={4} className="d-flex flex-column m-0 p-2">
            <Row className='m-0 p-0'>
              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Buat Soal</p>
              <Button variant='dark' className='m-2 mb-4' onClick={simpanSoal}>
                Tekan bila telah selesai membuat soal
              </Button>

              <p className='m-0 p-0 py-2 fs-4 fw-bold text-center'>Batasan Sumber Daya</p>
              <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                <Col xs={10}>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='number' placeholder="Batawan Waktu per Testcase" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan.waktu_per_testcase} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan : {...dataSoal.batasan, waktu_per_testcase : Number(e.target.value)}})
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
                    <Form.Control type='number' placeholder="Batawan Waktu Semua Testcase" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan.waktu_total} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan : {...dataSoal.batasan, waktu_total : Number(e.target.value)}})
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
                    <Form.Control type='number' placeholder="Batawan Memori" className='m-2 py-1 text-center fs-6' value={dataSoal.batasan.memori} onChange={(e) => {
                      setDataSoal({...dataSoal, batasan : {...dataSoal.batasan, memori : Number(e.target.value)}})
                    }}/>
                  </InputGroup>
                </Col>
                <Col xs={2} className='d-flex flex-column justify-content-center'>
                  <p className='fs-6 text-start m-0 p-0'>KB</p>
                </Col>
              </Col>
              <p className='m-0 p-0 pb-2 fs-4 fw-bold text-center'>Testcase</p>
              <p className='m-0 p-0 pb-2 fs-6 text-start'>Total Testcase: {dataSoal.daftar_testcase.length}</p>
              <Row className='m-0 p-0'>
                {
                  dataSoal.daftar_testcase.map((testcase : Testcase, index : number) => {
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
                                if (dataSoal.daftar_testcase.filter((element) => element.publik).length > 5) {
                                  testcase.publik = false
                                }
                                setDataSoal({...dataSoal, daftar_testcase : [...dataSoal.daftar_testcase]})
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
                if (dataSoal.daftar_testcase.length < 20) {
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

export default HalamanBuatSoal