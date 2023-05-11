import { useState, useEffect } from 'react'
import { Button, Col, Container, Form, InputGroup, Modal, Row } from 'react-bootstrap'
import Header from './Header'
import ModelTestcase from '../model/ModelTestcase';
import { test } from 'node:test';
import ModelInputModal from '../model/ModelInputModal';

function HalamanBuatSoal() {

  const [daftarTestcase, setDaftarTestcase] = useState<ModelTestcase[]>([])
  const [popupInputString, setPopupInputString] = useState<boolean>(false)
  const [dataModalString, setDataModalString] = useState<ModelInputModal<string>>({
    testcase : null,
    namaAttribute : "",
    nilai : ""
  });

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
      });
    }
    function loadScriptCustomCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor-custom-build") == null) {
          const script = document.createElement('script');
          script.innerHTML = `
            ClassicEditor.create( document.querySelector( '.editor' ), {
                licenseKey: '',
            })
            .then( editor => {
                window.editor = editor;
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: n96xuuc5ag4v-nk96buq2xi5g' );
                console.error( error );
            });`;
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor-custom-build"
          document.body.appendChild(script);
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

  const hapusTestcase = (testcase : ModelTestcase) => {
    setDaftarTestcase(daftarTestcase.filter(t => t !== testcase))
  }

  const tambahTestcase = (testcase : ModelTestcase) => {
    setDaftarTestcase(dataSebelumnya => [...dataSebelumnya, testcase])
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

  return (
    <>
      <Container className='min-vh-100 min-vw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Row className='m-0 p-0'>
          <Col sm={12} md={8} lg={8} xl={8} className="d-flex flex-column m-0 p-0">
            <Row className='m-2 p-0 d-flex flex-column'>
              <Col className='m-0 p-0'>
                <Row className='mx-5 mb-4 p-0 d-flex flex-column'>
                  <p className='my-2 p-0 fs-4 fw-bold text-center'>Judul Soal</p>
                  <InputGroup className='m-0 p-0'>
                    <Form.Control type='text' placeholder="Judul" className='m-2 p-0 text-center'/>
                  </InputGroup>
                </Row>
              </Col>
              <Col className='m-0 p-0'>
                <Row className='m-0 p-0 pb-4 d-flex flex-column'>
                  <p className='m-0 py-2 fs-4 fw-bold text-center'>Soal</p>
                  <div className="editor"></div>
                </Row>
              </Col>
            </Row>
          </Col>
          <Col sm={12} md={4} lg={4} xl={4} className="d-flex flex-column m-0 p-0">
            <Row className='m-0 p-2'>
              <p className='fs-4 fw-bold text-center pb-1'>Testcase</p>
              <p className='fs-6 text-start pb-1'>Total Testcase: {daftarTestcase.length}</p>
              <Row className='m-0 p-0'>
                {
                  daftarTestcase.map(testcase => {
                    return (
                      <>
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
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0'>Atur Publik</Button>
                          </Col>
                          <Col xs={3} className='m-0 p-0'>
                            <Button variant='light' className='w-100 m-0 border border-dark rounded-0' onClick={() => {
                               hapusTestcase(testcase)
                            }}>
                              Hapus
                            </Button>
                          </Col>
                        </Col>
                      </>
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
                      placeholder={"Tuliskan " + dataModalString.namaAttribute} 
                      onChange={(e) => {
                        setDataModalString({...dataModalString, nilai : e.target.value})
                      }}
                      value={dataModalString.nilai}
                      className='mx-2 p-0'
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
                tambahTestcase({
                  testcase : "",
                  jawaban : "",
                  publik : false
                })
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