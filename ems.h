#ifndef EMS_H
#define EMS_H

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <ctype.h>

#define MAX_USERS 100
#define MAX_FRIENDS 50
#define NAME_LEN 50
#define PASS_LEN 50
#define MSG_LEN 256
#define USER_DB "users.dat"

typedef struct {
    char name[NAME_LEN];
    char password[PASS_LEN];
    
    // Friends are people where the connection is mutual
    char friend_list[MAX_FRIENDS][NAME_LEN];
    int friend_count;
    
    // Waiting list: People who have requested ME
    char waiting_list[MAX_FRIENDS][NAME_LEN];
    int waiting_count;

    // Sent requests: People I have requested (to avoid double sending)
    char sent_requests[MAX_FRIENDS][NAME_LEN];
    int sent_count;
} User;

extern User users[MAX_USERS];
extern int user_count;
extern int current_user_idx;

// Core Functions
void load_users();
void save_users();
void handle_login();
void handle_register();
void menu_main_service();

// Helpers
int find_user_index(const char *name);
void get_current_time_str(char *buffer);
void clear_input_buffer();

#endif
