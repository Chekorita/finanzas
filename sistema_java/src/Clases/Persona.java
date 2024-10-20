package Clases;

public class Persona {
	private int id;
	private String nombre;
	private String apodo;
	private int id_usuario;

	public Persona() {}

	public Persona(int id, String nombre, String apodo, int id_usuario) {
		super();
		this.id = id;
		this.nombre = nombre;
		this.apodo = apodo;
		this.id_usuario = id_usuario;
	}

	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getNombre() {
		return nombre;
	}
	public void setNombre(String nombre) {
		this.nombre = nombre;
	}
	public String getApodo() {
		return apodo;
	}
	public void setApodo(String apodo) {
		this.apodo = apodo;
	}
	public int getId_usuario() {
		return id_usuario;
	}
	public void setId_usuario(int id_usuario) {
		this.id_usuario = id_usuario;
	}
}
